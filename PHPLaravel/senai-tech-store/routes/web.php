<?php
declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CatalogoController;

// Redireciona a raiz para o catalogo da loja de informatica
Route::redirect('/', '/catalogo');

// Rotas do catalogo da loja
Route::prefix('catalogo')->name('catalogo.')->group(function () {
    Route::get('/', [CatalogoController::class, 'index'])->name('index');
});
