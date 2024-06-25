<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lokacijas extends Model
{
    use HasFactory;
    protected $table = 'lokacijas';
    protected $primaryKey = 'lokacijas_id';
    public $incrementing = true;

    protected $fillable = [
        'lokacijas_id',
        'adrese',
        'apraksts',
    ];

    // Define the relationship with the Pakalpojumi model
    public function pakalpojumi()
    {
        return $this->hasMany(Pakalpojumi::class, 'lokacijas_id', 'lokacijas_id');
    }
}
