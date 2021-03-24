<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'title',
        'slug',
        'summary',
        'photo',
        'is_parent',
        'parent_id',
        'added_by',
        'status'
    ];

    protected $casts = [
        'created_at' => "datetime:d/m/Y",
    ];
}
