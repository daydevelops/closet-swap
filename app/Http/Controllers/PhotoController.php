<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePhotoRequest;
use App\Models\Photo;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePhotoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePhotoRequest $request)
    {
        $file = $request->file('photo');
        $file_name = uniqid(). '.' .File::extension($file->getClientOriginalName());

        Storage::disk('photos')->putFileAs('/',$file,$file_name);

        $photo = Photo::create([
            'product_id' => $request['product_id'],
            'file_name' => $file_name
        ]);

        if ($request->wantsJson()) {
            return $photo;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Photo  $photo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Photo $photo)
    {
        //
    }
}
