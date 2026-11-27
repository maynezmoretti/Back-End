<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Modelo de negocio que representa os produtos do catalogo de informatica.
 */
final class Produto extends Model {
    use HasFactory;

    protected $table = 'produtos';

    protected $fillable = [
        'categoria_id',
        'fornecedor_id',
        'sku',
        'nome',
        'descricao',
        'preco',
        'estoque',
        'unidade_medida',
        'ativo'
    ];

    public function categoria(): BelongsTo {
        return $this->belongsTo(Categoria::class);
    }

    public function fornecedor(): BelongsTo {
        return $this->belongsTo(Fornecedor::class);
    }
}
