<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Override;

class OrdemServico extends Model
{
    protected $fillable = [
        "codigo","titulo", "equipamento_id",
        "tipo", "prioridade", "status", "tecnico",
        "data_abertura", "prazo_limite"
    ];

    // função para retornar o equipamento daquela ordem de serviço
    public function equipamento(): BelongsTo {
        return $this->belongsTo(Equipamento::class);
    }

    // função para mapear como chave de retorno o código da ordem de serviço
    #[Override]
    public function getRouteKeyName(): string
    {
        return "codigo";
    }
}
