<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Livro extends Model
{
    protected $table = 'livro';

    protected $fillable = [
        'nome',
        'isbn',
        'edicao',
        'dataPublicacao',
        'valorEmprestimo',
        'qtdDisponivel',
        'descricao',
    ];

    protected $casts = [
        'nome' => 'string',
        'isbn' => 'string',
        'edicao' => 'integer',
        'dataPublicacao' => 'date',
        'valorEmprestimo' => 'double',
        'qtdDisponivel' => 'integer',
        'descricao' => 'string',
    ];

    public function emprestimo()
    {
        return $this->hasMany(Emprestimo::class);
    }

    public function autores()
    {
        return $this->belongsToMany(
            Autor::class,
            'escrito',
            'livro_id',
            'autor_id'
        );
    }

    public function editoras()
    {
        return $this->belongsToMany(
            Editora::class,
            'publicado',
            'livro_id',
            'editora_id'
        );
    }

}
