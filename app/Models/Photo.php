<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Photo extends Model
{
    protected $fillable = ['file_name','product_id'];

    protected $appends = ['is_primary','path'];

    use HasFactory;

    public function product() {
        return $this->belongsTo(Product::class);
    }

    public function getIsPrimaryAttribute() {
        return $this->product()->select('primary_photo_id')->get()->first()->primary_photo_id == $this->id;
    }

    public function getPathAttribute() {
        return Storage::disk('photos')->url('') . '/' . $this->file_name;
    }

}
