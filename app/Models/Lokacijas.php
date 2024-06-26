<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Lokacijas extends Model
{
    use HasFactory;

    protected $table = 'lokacijas';
    protected $primaryKey = 'lokacijas_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'lokacijas_id', 'adrese', 'apraksts'
    ];

    public static function boot()
    {
        parent::boot();

        // Automatically generate UUID for lokacijas_id if not set
        static::creating(function ($model) {
            if (empty($model->lokacijas_id)) {
                $model->lokacijas_id = (string) Str::uuid();
            }
        });
    }

    public function pakalpojumi()
    {
        return $this->hasMany(Pakalpojumi::class, 'lokacijas_id');
    }
}
