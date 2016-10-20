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
        'title', 'user_id', 'date', 'slug', 'category_id', 'description', 'timezone', 'is_private', 'status',
    ];

    /**
     * Get the user for the event.
     */
    public function user() {
        return $this->belongsTo('App\User');
    }

    /**
     * Get the category for the event.
     */
    public function category() {
        return $this->belongsTo('App\Category');
    }

    public static function getEvents($categoryId = null, $userId = null) {
        $query = Event::where('status', 1); // acceopted
        $query->where('is_private', 0); // not private
        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }
        if ($userId) {
            $query->where('user_id', $userId);
        }
        $query->orderBy('created_at', 'DESC'); // sorting
        return $query->paginate(10);
    }

}
