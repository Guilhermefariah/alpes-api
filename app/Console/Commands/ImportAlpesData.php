<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Item;
use Illuminate\Support\Facades\Http;

class ImportAlpesData extends Command
{
    protected $signature = 'alpes:import';
    protected $description = 'Importa dados da Alpes One API';

    public function handle()
    {
        $this->info('Buscando dados da API...');

        $response = Http::get('https://hub.alpes.one/api/v1/integrator/export/1902');

        if ($response->successful()) {
            $data = $response->json();

            foreach ($data as $itemData) {
                Item::updateOrCreate(
                    ['code' => $itemData['code']],
                    [
                        'name' => $itemData['name'],
                        'description' => $itemData['description'],
                        'price' => $itemData['price'],
                    ]
                );
            }

            $this->info('Importação concluída com sucesso!');
        } else {
            $this->error('Falha ao buscar dados da API.');
        }
    }
}
