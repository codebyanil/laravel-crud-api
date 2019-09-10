<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    
    // the table associated with the model
    protected $table = 'contact';
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
