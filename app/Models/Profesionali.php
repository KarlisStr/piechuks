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
        'profesionalis_id',
        'vards_uzvards',
        'epasts',
        'telefons',
        'bankas_konts',
        'statuss',
        'user_id',
        'admin_id',
    ];

    // Define the relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Define the relationship with the Admin model
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id', 'admin_id');
    }
}
