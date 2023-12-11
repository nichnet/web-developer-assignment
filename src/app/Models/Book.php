<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

/**
 * Book Model
 */
class Book extends Model {
    
    // Mass-assigned vars using create method 
    protected $fillable = [
        'title', 
        'author'
    ];
}