<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    // the table associated with the model
    protected $table = 'books';
    // the attributes that are mass assignable
    protected $fillable = ['user_id', 'name',  'author', 'phone', 'address','description'];
    // hidden fields
    protected $hidden = ['updated_at'];


    /*
     * --------------------------------------------------
     * Relation functions
     * --------------------------------------------------
     *  */

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
