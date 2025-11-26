<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Editora extends Model
{
    protected $table = 'editora';

    protected $fillable = [
        'nome',
    ];

    protected $casts = [
        'nome' => 'string',
    ];

    public function livros()
    {
        return $this->belongsToMany(
            Livro::class,
            'publicado',
            'editora_id',
            'livro_id'
        );
    }
}
