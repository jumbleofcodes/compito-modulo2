<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;


    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'posts';

    /**
     * set fillable fields for filtering
     *
     * @var array
     */
    protected $fillable = ['title', 'description', 'user_id', 'id'];

    /**
     * set string fields for filtering
     * @var array
     */
    protected $likeFilterFields = ['title', 'description'];



    //*********RELATIONS********** */
    /**
     *
     * Get Owner
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    /**
     * Get tags
     * @return BelongsToMany
     */
    public function tags() : BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }
}
