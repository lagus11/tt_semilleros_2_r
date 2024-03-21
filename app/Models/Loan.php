<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    protected $table = 'loans';


    protected $fillable = [
        'client_id',
        'book_id',
        'desired',
        'start_date',
        'end_date',
        'return_date',
    ];

    public $timestamps = true;

    public function client()
    {
        return $this->belongsTo(User::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
    
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

}
