<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    
    // the table associated with the model
    protected $table = 'contacts';
    // the attributes that are mass assignable
    protected $fillable = ['user_id', 'name',  'email', 'phone', 'address'];
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
