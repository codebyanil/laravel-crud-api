<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    // the table associated with the model
    protected $table = 'book';
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
