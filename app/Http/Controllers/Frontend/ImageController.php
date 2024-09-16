<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Collection;
use App\Models\Image;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

class ImageController extends Controller
{
    public function index(int $collection_id)
    {
        $images = Image::whereCollectionId($collection_id)->get();
        return view('frontend.images.index', compact('images', 'collection_id'));
    }

    public function create(int $collection_id)
    {
        return view('frontend.images.create', compact('collection_id'));
    }

    public function store(int $collection_id, Request $request)
    {
        $validatedData = $request->all();
        $collection = Collection::findOrFail($collection_id);
        
        if (!$request->hasFile('image')) {
            return redirect()->back()->withErrors('No image file uploaded');
        }
        
        $filePath = $this->_uploadImageAndGetFilePath($request->file('image'));

        $newImage = new Image();
        $newImage->title = $validatedData['title'];
        $newImage->description = $validatedData['description'];
        $newImage->url = $filePath;

        $collection->images()->save($newImage);
        return redirect(route('images.index', compact('collection_id')));
    }

    private function _uploadImageAndGetFilePath(UploadedFile $imageFile)
    {
        $fileName = $this->_prepareUniqueFileName($imageFile->getClientOriginalName());
        $uploadedFile = $imageFile->storeAs('collection/images', $fileName, 'public');
        return $uploadedFile;
    }

    private function _prepareUniqueFileName(string $originalFileName)
    {
        $fileNameArray = explode('.', $originalFileName);
        $mimeType = array_pop($fileNameArray);
        $fileName = implode('-', $fileNameArray);
        $currentDateTime = Str::slug(Carbon::now()->toDateTimeString());
        return $fileName  .$currentDateTime . '.' . $mimeType;
    }
}
