<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pieteikumi extends Model
{
    use HasFactory;

    protected $table = 'pieteikumi';
    protected $primaryKey = 'pieteikums_id';
    public $incrementing = true; // Since your primary key is an auto-increment integer
    protected $keyType = 'int';

    protected $fillable = [
        'laiks',
        'apraksts',
        'pakalpojuma_id',
        'klients_id',
        'statuss',
    ];

    // Define the relationship with the Pakalpojumi model
    public function pakalpojums()
    {
        return $this->belongsTo(Pakalpojumi::class, 'pakalpojuma_id');
    }

    // Define the relationship with the Klienti model
    public function klients()
    {
        return $this->belongsTo(Klienti::class, 'klients_id');
    }
}
