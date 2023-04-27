<?php

namespace App\Http\Controllers;

use App\Models\Logo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\File;

class LogoController extends Controller
{
    public function list()
    {
        return auth()->user()->logos()
            ->get(['id', 'image_url', 'width', 'height']);
    }

    public function store()
    {
        request()->validate(['file' => ['file', File::image()->max(2 * 1024)]]);

        $logo = new Logo();
        $logo->user_id = auth()->user()->id;

        $image_path = request()->file('file')->storePublicly('uploads');
        $logo->image_url = $image_path;
        [$logo->width, $logo->height] = getimagesize(Storage::path($image_path));

        $logo->save();
    }

    public function destroy(Logo $logo)
    {
        if($logo->user_id === auth()->user()->id) {
            Storage::delete($logo->image_url);
            $logo->delete();
        } else return response(status: 400);
    }
}