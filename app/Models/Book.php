<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'books';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'title',
        'category_id',
        'quantity',
        'editorial_id'
    ];

    public $timestamps = true;

    public function writers()
    {
        return $this->belongsToMany(Writer::class, 'book_writer', 'book_id', 'writer_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    
    public function editorial()
    {
        return $this->belongsTo(Editorial::class);
    }

}
