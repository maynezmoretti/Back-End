<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Modelo de negocio que representa os fornecedores e distribuidores de tecnologia.
 */
final class Fornecedor extends Model {
    use HasFactory;

    protected $table = 'fornecedores';

    protected $fillable = [
        'razao_social',
        'cnpj',
        'email',
        'telefone',
        'cidade',
        'estado'
    ];

    public function produtos(): HasMany {
        return $this->hasMany(Produto::class);
    }
}
