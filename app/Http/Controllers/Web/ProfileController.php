<?php

namespace App\Http\Controllers\Web;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Album;
use App\Models\Photo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    public function index($slug)
    {
        $show_user = User::with(['profile'])->where('id', $slug)->first();
        return Inertia::render('Web/User/Profile', compact('show_user'));
    }

    public function photos($id)
    {
        $photos = Photo::orderBy('created_at', 'DESC')->where('user_id', $id)->where('private', 0)->with(['user', 'user.profile'])->paginate(15);
        return $photos;
    }

    public function albums($id)
    {
        $albums = Album::orderBy('created_at', 'DESC')->where('user_id', $id)->where('private', 0)->with(['photos'])->withCount('photos')->get();
        return $albums;
    }
}
