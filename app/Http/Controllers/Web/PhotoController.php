<?php

namespace App\Http\Controllers\Web;

use Inertia\Inertia;
use App\Models\Album;
use App\Models\Photo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PhotoController extends Controller
{
    public function photo($slug)
    {
        $photo = Photo::where('slug', $slug)->with(['user', 'user.profile', 'album'])->first();
        $album = Album::with(['photos' => function($q){
            $q->where('private', 0);
        }])->where('id', $photo->album_id)->first();
        return Inertia::render('Web/Photo/Photo', compact('photo', 'album'));
    }

    public function photos()
    {
        $photos = Photo::orderBy('created_at', 'DESC')->where('private', 0)->with(['user', 'user.profile'])->paginate(15);
        return $photos;
    }
}
