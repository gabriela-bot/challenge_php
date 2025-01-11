<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Entries extends Model
{
    protected $fillable = ['ip','response','request', 'endpoint', 'code', 'user_id'];
}
