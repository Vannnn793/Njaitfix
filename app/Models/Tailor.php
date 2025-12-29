<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tailor extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'nama', 'umur', 'alamat', 'skill', 'no_hp', 'deskripsi', 'harga'
    ];

    protected $casts = [
        'specializations' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

public function photos()
{
    return $this->hasMany(Photo::class, 'user_id', 'user_id');
}
    // public function orders()
    // {
    //     return $this->hasMany(Order::class);
    // }

    // app/Models/Tailor.php
public function ratings()
{
    return $this->hasMany(\App\Models\Rating::class)->with(['user', 'replies.user']);
}


public function averageRating()
{
    return $this->ratings()->avg('rating');
}


}
