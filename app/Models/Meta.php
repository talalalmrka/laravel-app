<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meta extends Model
{
    /** @use HasFactory<\Database\Factories\MetaFactory> */
    use HasFactory;
    protected $fillable = [
        'model_type',
        'model_id',
        'key',
        'value',
    ];
    public function model()
    {
        return $this->morphTo('model');
    }
}
