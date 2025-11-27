<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pessoa extends Model
{
    protected $table = 'pessoa';

    protected $fillable = [
        'nome',
        'cpf',
        'telefone',
        'endereco',
    ];

    protected $casts = [
        'nome'      => 'string',
        'cpf'       => 'string',
        'telefone'  => 'string',
        'endereco'  => 'string',
    ];

    public function cliente()
    {
        return $this->hasMany(Cliente::class);
    }

    public function funcionario()
    {
        return $this->hasMany(Funcionario::class);
    }

}
