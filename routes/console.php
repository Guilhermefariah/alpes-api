<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Console\Commands\ImportAlpesData;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Comando ImportAlpesData
Artisan::command('alpes:import', function () {
    $this->call(ImportAlpesData::class);
})->purpose('Importa dados da Alpes');
