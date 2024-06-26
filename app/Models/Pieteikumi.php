<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pieteikumi extends Model
{
    protected $table = 'pieteikumi';
    public function pakalpojums()
    {
        return $this->belongsTo(Pakalpojumi::class, 'pakalpojuma_id', 'pakalpojuma_id');
    }

    public function klients()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
