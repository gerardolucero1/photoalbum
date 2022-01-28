<?php

namespace App\Http\Controllers\System;

use Image;
use App\Models\Sale;
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
        $photos = Photo::where('album_id', null)->doesntHave('sales')->get();
        return Inertia::render('System/Photos/Index', compact('photos'));
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
        $photo = Photo::with(['album', 'tags'])->find($id);
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
        $photo = Photo::with('album')->with('tags')->find($id);
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
        $photo->single_sale = $data->single_sale;
        $photo->price = $data->price;
       
        $photo->private = $data->private;
        
        if ($archivo = $request->file('file')) {
            $free_disk = Auth::user()->profile->disk_space - (Auth::user()->photos->sum('size') / 1000000);
        
            if ($request->size / 1000000 > $free_disk) {
                return response([
                    'message' => 'Espacio en disco excedido.'
                ], 500); 
            }

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

            $photo->size = $archivo->getSize();
            $photo->fill(['url_preview' => asset($url.'images/'.$thumbName.'-thumbnail.'.$guessExtension)]);
            $photo->fill(['url_photo' => asset($url.'images/'.$thumbName.'.'.$guessExtension)]);

        }
        $photo->syncTags($data->tags);
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

    public function destroySale($id, $idSale)
    {
        $photo = Photo::find($id);
        $sale = Sale::find($idSale);
        $sale->photos()->detach($photo->id);
        // 

        // if(is_null($photo->album)){
        //     $photo->delete();
        // }else{
        //     $sale = Sale::find($idSale);
        //     $sale->photos()->detach($photo->id);
        // }

        return;
    }

    public function upload(Request $request)
    {
        $free_disk = Auth::user()->profile->disk_space - (Auth::user()->photos->sum('size') / 1000000);
        
        if ($request->size / 1000000 > $free_disk) {
            return response([
                'message' => 'Espacio en disco excedido.'
            ], 500); 
        }

        $array_images = [];

        if ($archivo = $request->file('files')) {
            foreach ($archivo as $file) {

                $image = new Photo();
                $image->user_id = Auth::user()->id;
                $image->album_id = null;
                $image->description = 'Hi, Binnie!';
                $image->private = 0;
                $image->size = $file->getSize();

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
