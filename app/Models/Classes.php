<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Classes extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'date',
        'start_time',
        'end_time',
        'capacity',
    ];

    /**
     * The techers that belong to the Classes
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function teachers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'users_has_classes', 'class_id', 'user_id')
        ->whereHas('groups', function($query){
            $query->where('id', 3);
        })
        ->wherePivot('status', true)
        ->withTimestamps();
    }

    /**
     * The students that belong to the Classes
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function students(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'users_has_classes', 'class_id', 'user_id')
        ->whereHas('groups', function($query){
            $query->where('id', 2);
        })
        ->wherePivot('status', true)
        ->withTimestamps();
    }
}
