<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pakalpojumi extends Model
{
    use HasFactory;

    protected $table = 'pakalpojumi';
    protected $primaryKey = 'pakalpojuma_id';
    public $incrementing = true; // Ensure this is true if it's an auto-incrementing integer
    protected $keyType = 'int';  // Ensure this is 'int' if it's an auto-incrementing integer

    protected $fillable = [
        'apraksts', 'cena', 'kategorijas_nosaukums', 'profesionalis_id', 'nosaukums', 'adrese'
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
