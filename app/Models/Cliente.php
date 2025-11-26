<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'cliente';

    protected $fillable = [
        'matricula',
        'pessoa_id',
    ];

    protected $casts = [
        'matricula' => 'string',
        'pessoa_id' => 'integer',
    ];

    public function pessoa()
    {
        return $this->belongsTo(Pessoa::class);
    }

    public function emprestimo()
    {
        return $this->hasMany(Emprestimo::class);
    }

}
