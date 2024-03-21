<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookWriter extends Model
{
    use HasFactory;
    protected $table = 'book_writer';

    protected $fillable = [
        'book_id',
        'writer_id',
    ];

    public $timestamps = false;

}
