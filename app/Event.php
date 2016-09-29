<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'user_id', 'start_date', 'slug', 'description', 'is_private',
    ];

    public function user() {
        return $this->belongsTo('App\User');
    }

}
