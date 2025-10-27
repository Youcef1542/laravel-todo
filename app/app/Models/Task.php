<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    // Colonnes qu'on peut remplir automatiquement
    protected $fillable = ['title', 'completed'];

    // Pour que 'completed' soit reconnu comme un booléen
    protected $casts = [
        'completed' => 'boolean',
    ];
}

