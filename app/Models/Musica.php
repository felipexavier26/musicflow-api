<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Musica extends Model
{
    use HasFactory;

    // Nome da tabela no banco
    protected $table = 'musicas';

    // Colunas preenchíveis via mass assignment
    protected $fillable = [
        'titulo',
        'visualizacoes',
        'youtube_id',
        'thumb',
        'url',
        'status',
    ];

    // Desative timestamps caso não sejam usados na tabela
    public $timestamps = true;
}
