<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;
    protected function setKeysForSaveQuery($query)
    {
        $query
            ->where('user_id', '=', $this->getAttribute('user_id'))
            ->where('book_id', '=', $this->getAttribute('book_id'))
            ->where('start', '=', $this->getAttribute('start')); 

        return $query;
    } 

    protected $fillable = [
        'user_id',
        'copy_id',
        'start',
        'message'
    ];

    public function copy_c()
    {    return $this->hasOne(Book::class, 'book_id', 'book_id');   }

    public function user_c()
    {    return $this->hasOne(User::class, 'id', 'user_id');   }
}
