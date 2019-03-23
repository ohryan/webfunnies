<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Logs extends Model
{
    protected $fillable = [
        'status'
    ];

    protected function lastLog()
    {
        return $this->orderBy('created_at', 'desc')->first();
    }
}
