<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaveInstance extends Model
{
    use HasFactory;

    protected $table = 'instance';

    public function scrapData()
    {
        return $this->hasOne(Insight::class, 'instance_id');
    }
}
