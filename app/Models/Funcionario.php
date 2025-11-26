<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Funcionario extends Model
{
    protected $table = 'funcionario';

    protected $fillable = [
        'matricula',
        'dataAdmissao',
        'dataDemissao',
        'pessoa_id',
    ];

    protected $casts = [
        'matricula' => 'string',
        'dataAdmissao' => 'date',
        'dataDemissao' => 'date',
        'pessoa_id' => 'integer',
    ];

    public function pessoa()
    {
        return $this->belongsTo(Pessoa::class);
    }

    public function emprestimos()
    {
        return $this->belongsToMany(
            Emprestimo::class,
            'responsavel_emprestimo',
            'funcionario_id',
            'emprestimo_id'
        );
    }
}
