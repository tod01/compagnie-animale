<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePost;
use App\Models\Ad;
use App\Models\Category;
use App\Models\Photo;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Pages.ads');
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StorePost $request)
    {

        $animal_id = (new AnimalController)->addAnimal($request);

        $post = new Ad();
        $post->description = $request['post_text'];
        $post->category_id = Category::where('category_type','AnimalPost')->first()['id'];
        $post->type_of_post= $request['type_of_post'];
        $post->price = $request['price'] ?? 0;
        $post->animal_id = $animal_id;
        $post->user_id = $request['user_id'];
        $post->title   = $request['post_title'];
        $post->user_position = $request['user_position'];
        $post->save();

        (new PhotoController())->addPictures($request['images'], $post);

        return response()->json(["message" => "Done"], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ad  $ad
     * @return \Illuminate\Http\Response
     */
    public function show(Ad $ad)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ad  $ad
     * @return \Illuminate\Http\Response
     */
    public function edit(Ad $ad)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ad  $ad
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ad $ad)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ad  $ad
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ad $ad)
    {
        //
    }
}
