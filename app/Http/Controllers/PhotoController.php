<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{
    public function addPictures($images, $post) {

        foreach ($images as $image) {
            $image_path = Storage::disk('uploads')->put($post->user->email.'/posts/'. $post->id, $image);

            $img = new Photo();
            $img->path = '/uploads/'. $image_path;
            $img->ad_id = $post->id;
            $img->save();
        }
    }
}
