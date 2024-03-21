<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Writer extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'writers';
    protected $dates = ['deleted_at'];


    protected $fillable = [
        'name',
        'deleted_at',
    ];

    public $timestamps = false;

    public function books()
    {
        return $this->belongsToMany(Book::class, 'book_writer', 'writer_id', 'book_id');
    }

}
