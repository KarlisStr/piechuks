<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profesionali extends Model
{
    use HasFactory;

    protected $table = 'profesionali';
    protected $primaryKey = 'profesionalis_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'profesionalis_id', 'vards_uzvards', 'epasts', 'telefons', 'bankas_konts', 'statuss', 'user_id', 'admin_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pakalpojumi()
    {
        return $this->hasMany(Pakalpojumi::class, 'profesionalis_id');
    }

    public function profileImage()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}
