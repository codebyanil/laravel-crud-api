<?php

namespace App\Models;

use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use Searchable;
    // the table associated with the model
    protected $table = 'books';
    // the attributes that are mass assignable
    protected $fillable = ['member_id', 'name',  'author', 'phone', 'address', 'description'];
    // hidden fields
    protected $hidden = ['updated_at'];


    /*
     * --------------------------------------------------
     * Relation functions
     * --------------------------------------------------
     *  */

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
