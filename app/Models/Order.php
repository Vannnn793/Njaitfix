<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','tailor_id', 'nama', 'jumlah', 'ukuran', 'deskripsi', 'design', 'harga'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function tailor()
{
    return $this->belongsTo(Tailor::class);
}
public function ratings()
{
    return $this->hasMany(Rating::class);
}


}


