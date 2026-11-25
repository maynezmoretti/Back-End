<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Equipamento extends Model
{
    protected $fillable = [
        "tag", "nome", "setor", "criticidade", "status"
        ];

    // método para retornar as ordens de serviço vinculadas ao equipamento
    public function ordensServico(): HasMany {
        return $this -> hasMany(OrdemServico::class);
    }
}