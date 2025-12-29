<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    use HasFactory;

    protected $table = 'tailor_photos'; // pastikan nama tabel benar

    protected $fillable = [
        'user_id',
        'path',
        'extra_price',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function tailor()
    {
        return $this->belongsTo(Tailor::class, 'user_id');
    }
}
