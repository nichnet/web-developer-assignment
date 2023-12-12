<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

/**
 * Book Model
 */
class Book extends Model {

    public $timestamps = false;
    
    // Mass-assigned vars using create method 
    protected $fillable = [
        'id',
        'title', 
        'author'
    ];
}