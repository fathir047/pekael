<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ruangans extends Model
{

    protected $fillable = ['cover', 'nama', 'kapasitas', 'fasilitas'];

    public function bookings()
    {
        return $this->hasMany(bookings::class);
    }
 
    public function jadwals()
    {
        return $this->hasMany(jadwals::class);
    }

}
