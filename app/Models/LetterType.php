<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LetterType extends Model
{
    protected $table = 'letter_types';
    protected $guarded = [
        'id',
    ];

    public $timestamps = false;
}
