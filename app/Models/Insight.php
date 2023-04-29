<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Insight extends Model
{
    use HasFactory;

    protected $table = 'results';
    public $timestamps = false;

    public function insights()
    {
        return $this->hasMany(Insight::class, 'instance_id');
    }
}
