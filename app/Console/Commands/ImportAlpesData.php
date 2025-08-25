<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Item;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ImportAlpesData extends Command
{
    protected $signature = 'alpes:import';
    protected $description = 'Importa dados da Alpes One API';

    public function handle()
    {
        $this->info('Buscando dados da API...');

        try {
            $response = Http::timeout(10)->get('https://hub.alpes.one/api/v1/integrator/export/1902');

            if (!$response->successful()) {
                $this->error('Falha ao buscar dados da API. Status: ' . $response->status());
                Log::error('Falha na API Alpes', ['status' => $response->status()]);
                return;
            }

            $data = $response->json();
            $items = $data['data'] ?? $data;

            foreach ($items as $itemData) {
                $itemDataTransformed = [
                    'name'        => trim(($itemData['brand'] ?? '') . ' ' . ($itemData['model'] ?? '') . ' ' . ($itemData['version'] ?? '')),
                    'description' => $itemData['description'] ?? null,
                    'price'       => $itemData['price'] ?? null,
                    'color'       => $itemData['color'] ?? null,
                    'fuel'        => $itemData['fuel'] ?? null,
                    'year_model'  => $itemData['year']['model'] ?? null,
                    'year_build'  => $itemData['year']['build'] ?? null,
                    'photos'      => isset($itemData['fotos']) ? json_encode($itemData['fotos'], JSON_THROW_ON_ERROR) : null,
                    'sold'        => $itemData['sold'] ?? 0,
                ];

                Item::updateOrCreate(
                    ['code' => $itemData['id']],
                    $itemDataTransformed
                );
            }

            $this->info('Importação concluída com sucesso!');
            Log::info('Importação Alpes concluída', ['count' => count($items)]);
            
        } catch (\Exception $e) {
            $this->error('Erro ao importar dados: ' . $e->getMessage());
            Log::error('Erro na importação Alpes', ['exception' => $e]);
        }
    }
}
