<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EquipamentoController;
use App\Http\Controllers\OrdemServicoController;
use Illuminate\Support\Facades\Route;

// 1. Redirecionamento para o dashboard
Route::redirect("/", "/dashboard");

Route::get("/dashboard", [DashboardController::class , "index"])->name("dashboard");

// Rotas para equipamentos
Route::resource("equipamentos", EquipamentoController::class)->except(["show"]);

// Rotas para ordens de serviço
Route::resource("ordens", OrdemServicoController::class)->parameters(["ordens" => "ordem"]);
