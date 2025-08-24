<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Console\Commands\ImportAlpesData;
use Illuminate\Console\Scheduling\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Comando ImportAlpesData
Artisan::command('app:import-alpes-data', function () {
    $this->call(ImportAlpesData::class);
})->purpose('Importa dados da Alpes');

app(Schedule::class)->command('app:import-alpes-data')->hourly();
