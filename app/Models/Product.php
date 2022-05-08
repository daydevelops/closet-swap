<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'description',
        'gender',
        'size',
        'tags',
        'status',
        'primary_photo_id'
    ];

    protected $appends = ['liked'];

    protected $withCounts = ['likes'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function photos() {
        return $this->hasMany(Photo::class);
    }

    public function getLikedAttribute() {
        return auth()->check() && Like::where(['product_id'=>$this->id,'user_id'=>auth()->id()])->exists();
    }

    public function likes() {
        return $this->belongsToMany(User::class,'likes')->select(['users.id','users.name']);
    }

    public function like() {
        if (!$this->liked) {
            $this->likes()->attach(auth()->id());
        }
    }

    public function unlike() {
        if ($this->liked) {
            $this->likes()->detach(auth()->id());
        }
    }
}
