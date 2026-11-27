<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Modelo de negocio que representa as categorias da loja de informatica.
 */
final class Categoria extends Model {
    use HasFactory;

    protected $table = 'categorias';

    protected $fillable = [
        'nome',
        'slug',
        'descricao',
        'ativo'
    ];

    public function produtos(): HasMany {
        return $this->hasMany(Produto::class);
    }
}
