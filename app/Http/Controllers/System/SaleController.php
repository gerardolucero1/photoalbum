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
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sales = Sale::where('user_id', Auth::user()->id)->withCount('photos')->get();
        return Inertia::render('System/Sales/Index', compact('sales'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('System/Sales/Create');
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

        $sale = new Sale();
        $sale->user_id = Auth::user()->id;
        $sale->name = $data->name;
        $sale->description = $data->description;
        $sale->active = $data->active;
        $sale->price = $data->price;

        $sale->save();

        return;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sale = Sale::with('photos.album')->find($id);
        return Inertia::render('System/Sales/Show', compact('sale'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $sale = Sale::find($id);
        return Inertia::render('System/Sales/Edit', compact('sale'));
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

        $sale = Sale::find($id);
        $sale->name = $data->name;
        $sale->description = $data->description;
        $sale->active = $data->active;
        $sale->price = $data->price;
        $sale->save();

        return;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sale = Sale::find($id);
        $sale->delete();

        return;
    }

    public function selectPhotos(Request $request)
    {
        $album = Album::find($request->album_id);
        $sale = Sale::find($request->sale_id);

        $sale->photos()->syncWithoutDetaching($album->photos);

        $sale = Sale::withCount('photos')->find($request->sale_id);

        return $sale;
    }

    public function upload(Request $request, $id)
    {
        $free_disk = Auth::user()->profile->disk_space - (Auth::user()->photos->sum('size') / 1000000);
        
        if ($request->size / 1000000 > $free_disk) {
            return response([
                'message' => 'Espacio en disco excedido.'
            ], 500); 
        }
        
        $array_images = [];
        $array_ids = [];

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
                array_push($array_ids, $image->id);
            }
        }

        $sale = Sale::find($id);
        $sale->photos()->syncWithoutDetaching($array_ids);

        return $array_images;
    }

    public function changePassword(Request $request, $id)
    {
        if ($request->password) {
            $sale = Sale::find($id);
            $sale->password = Hash::make($request->password);
            $sale->save();
        }

        return;
    }
}
