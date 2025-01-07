<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IncomingLetter extends Model
{
    protected $table = "incoming_letters";
    protected $guarded = ['id'];
}
