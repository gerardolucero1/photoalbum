<?php

namespace App\Http\Controllers\System;

use Image;
use Inertia\Inertia;
use App\Models\Photo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $photo = Photo::with('album')->find($id);
        return Inertia::render('System/Photos/Show', compact('photo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $photo = Photo::with('album')->find($id);
        return Inertia::render('System/Photos/Edit', compact('photo'));
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

        $photo = Photo::find($id);
        $photo->name = $data->name;
        $photo->description = $data->description;
        $photo->private = $data->private;
        
        if ($archivo = $request->file('file')) {
            $url = 'https://goovem.s3.us-west-1.amazonaws.com/';
            $thumbName = md5($archivo->getRealPath() . time());
            $guessExtension = $archivo->guessExtension();
            $path = $archivo->storeAs('images', $thumbName.'.'.$guessExtension  ,'s3');

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

            $photo->fill(['url_preview' => asset($url.'images/'.$thumbName.'-thumbnail.'.$guessExtension)]);
            $photo->fill(['url_photo' => asset($url.'images/'.$thumbName.'.'.$guessExtension)]);

        }

        $photo->save();

        return $photo;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $photo = Photo::find($id);
        $photo->delete();

        return;
    }
}
