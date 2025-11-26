<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Emprestimo extends Model
{
    protected $table = 'emprestimo';

    protected $fillable = [
        'valorPraticado',
        'dataInicio',
        'dataFimEsperado',
        'dataFimReal',
        'renovacoes',
        'cliente_id',
        'livro_id',
    ];

    protected $casts = [
        'valorPraticado' => 'double',
        'dataInicio' => 'date',
        'dataFimEsperado' => 'date',
        'dataFimReal' => 'date',
        'renovacoes' => 'integer',
        'cliente_id' => 'integer',
        'livro_id' => 'integer',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function livro()
    {
        return $this->belongsTo(Livro::class);
    }

    public function responsaveis()
    {
        return $this->belongsToMany(
            Funcionario::class,
            'responsavel_emprestimo',
            'emprestimo_id',
            'funcionario_id'
        );
    }

}
