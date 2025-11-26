<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Autor extends Model
{
    protected $table = 'autor';

    protected $fillable = [
        'nome',
    ];

    protected $casts = [
        'nome' => 'string',
    ];

    public function livros()
    {
        return $this->belongsToMany(
            Autor::class,
            'escrito',
            'autor_id',
            'livro_id'
        );
    }

}
