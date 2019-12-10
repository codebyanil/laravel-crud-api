<?php

namespace App\Models;

use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    use Searchable;
    // the table associated with the model
    protected $table = 'stories';
    // the attributes that are mass assignable
    protected $fillable = ['member_id', 'name', 'title', 'address', 'description'];
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
