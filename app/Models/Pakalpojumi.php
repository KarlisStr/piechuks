<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pakalpojumi extends Model
{
    use HasFactory;

    protected $table = 'pakalpojumi';
    protected $primaryKey = 'pakalpojuma_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'pakalpojuma_id', 'apraksts', 'cena', 'kategorijas_nosaukums', 'profesionalis_id', 'nosaukums', 'adrese'
    ];

    public function profesionali()
    {
        return $this->belongsTo(Profesionali::class, 'profesionalis_id');
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }
    public function favorites()
    {
        return $this->hasMany(Favorite::class, 'pakalpojuma_id');
    }
}
