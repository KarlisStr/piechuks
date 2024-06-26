<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Klienti extends Model
{
    use HasFactory;
    protected $table = 'klienti';
    protected $primaryKey = 'klients_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'klients_id', 'vards_uzvards', 'epasts', 'telefons', 'bankas_konts', 'statuss', 'parole'
    ];
}
