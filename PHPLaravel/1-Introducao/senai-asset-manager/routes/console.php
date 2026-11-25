<?php
declare(strict_types=1);

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Models\Ativo;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Exibe o diagnóstico corporativo da plataforma
Artisan::command('senai:status', function () {
    $total = Ativo::where('status', 'operacional')->count();

    $this->info('SENAI Asset Manager');
    $this->line('Ambiente: ' . config('app.env'));
    $this->line('Ativos operacionais: ' . $total);
})->purpose('Exibe o status da plataforma SENAI');
