<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pakalpojumi extends Model
{
    use HasFactory;

    protected $primaryKey = 'pakalpojuma_id';
    public $incrementing = true;
    protected $table = 'pakalpojumi';

    protected $fillable = [
        'pakalpojuma_id',
        'apraksts',
        'kategorijas_nosaukums',
        'cena',
        'lokacijas_id',
        'profesionalis_id',
    ];

    // Define the relationship with the Profesionali model
    public function profesionalis()
    {
        return $this->belongsTo(Profesionali::class, 'profesionalis_id', 'profesionalis_id');
    }

    // Define the relationship with the Lokacijas model
    public function lokacija()
    {
        return $this->belongsTo(Lokacijas::class, 'lokacijas_id', 'lokacijas_id');
    }
}
