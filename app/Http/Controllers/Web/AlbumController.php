<?php

namespace App\Http\Controllers\Web;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Album;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AlbumController extends Controller
{
    public function album($slug)
    {
        
        $album = Album::with('tags')->with(['photos' => function($q){
            $q->where('private', 0);
        }])->where('id', $slug)->first();

        $album_owner = User::with('profile')->find($album->user_id);

        return Inertia::render('Web/Album/Show', compact('album', 'album_owner'));
    }
}
