<?php

namespace App\Http\Controllers\System;

use Image;
use App\Models\Sale;
use Inertia\Inertia;
use App\Models\Album;
use App\Models\Photo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AlbumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $albums = Album::withCount('photos')->get();
        $sales = Sale::where('active', 1)->withCount('photos')->get();

        return Inertia::render('System/Albums/Index', compact('albums', 'sales'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('System/Albums/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = json_decode($request->props);

        $album = new Album();
        $album->user_id = Auth::user()->id;
        $album->name = $data->name;
        $album->description = $data->description;
        $album->private = $data->private;
        $album->active = $data->active;
        $album->price = $data->price;

        if ($archivo = $request->file('file')) {
            // Guardar imagen original
            $url = 'https://goovem.s3.us-west-1.amazonaws.com/';
            $thumbName = md5($archivo->getRealPath() . time());
            $guessExtension = $archivo->guessExtension();

            //Guardar thumb
            $img = Image::make($archivo);
            $img->resize(500, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $resource = $img->stream()->detach();
            Storage::disk('s3')->put(
                'images/' . $thumbName.'-thumbnail.'.$guessExtension,
                $resource
            );

            $album->fill(['photo_url' => asset($url.'images/'.$thumbName.'-thumbnail.'.$guessExtension)]);
        }
        $album->save();

        return $album;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $album = Album::with('photos')->find($id);
        return Inertia::render('System/Albums/Show', compact('album'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $album = Album::find($id);
        return Inertia::render('System/Albums/Edit', compact('album'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = json_decode($request->props);

        $album = Album::find($id);
        $album->user_id = Auth::user()->id;
        $album->name = $data->name;
        $album->description = $data->description;
        $album->private = $data->private;
        $album->active = $data->active;
        $album->price = $data->price;
        
        if ($archivo = $request->file('file')) {
            // Guardar imagen original
            $url = 'https://goovem.s3.us-west-1.amazonaws.com/';
            $thumbName = md5($archivo->getRealPath() . time());
            $guessExtension = $archivo->guessExtension();

            //Guardar thumb
            $img = Image::make($archivo);
            $img->resize(500, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $resource = $img->stream()->detach();
            Storage::disk('s3')->put(
                'images/' . $thumbName.'-thumbnail.'.$guessExtension,
                $resource
            );

            $album->fill(['photo_url' => asset($url.'images/'.$thumbName.'-thumbnail.'.$guessExtension)]);
        }
        $album->photos()->update([ 'private' => $data->private ]);
        foreach ($album->photos as $photo) {
            $photo->syncTags($data->tags);
        }
        $album->save();

        return $album;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function upload(Request $request, $id)
    {
        $array_images = [];
        $album = album::find($id);

        if ($archivo = $request->file('files')) {
            foreach ($archivo as $file) {

                $image = new Photo();
                $image->user_id = Auth::user()->id;
                $image->album_id = $id;
                $image->description = 'Hi, Binnie!';
                $image->private = $album->private;

                $url = 'https://goovem.s3.us-west-1.amazonaws.com/';
                $thumbName = md5($file->getRealPath() . time());
                $guessExtension = $file->guessExtension();
                $path = $file->storeAs('images', $thumbName.'.'.$guessExtension  ,'s3');

                //Guardar thumb
                $img = Image::make($file);
                $img->resize(500, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $resource = $img->stream()->detach();
                Storage::disk('s3')->put(
                    'images/' . $thumbName.'-thumbnail.'.$guessExtension,
                    $resource
                );

                $image->name = $file->getClientOriginalName();

                $image->fill(['url_preview' => asset($url.'images/'.$thumbName.'-thumbnail.'.$guessExtension)]);
                $image->fill(['url_photo' => asset($url.'images/'.$thumbName.'.'.$guessExtension)]);

                $image->save();

                array_push($array_images, $image);
            }
        }

        return $array_images;
    }
}
