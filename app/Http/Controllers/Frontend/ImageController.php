<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\ImageFromRequest;
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

    public function store(int $collection_id, ImageFromRequest $request)
    {
        $validatedData = $request->validated();
        Collection::findOrFail($collection_id);
        $filePath = $this->_uploadImageAndGetFilePath($validatedData['image']);

        $newImage = new Image();
        $newImage->title = $validatedData['title'];
        $newImage->description = $validatedData['description'];
        $newImage->url = $filePath;
        $newImage->collection_id = $collection_id;
        $newImage->save();

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

    public function delete(int $collection_id, int $image_id)
    {
        Collection::findOrFail($collection_id);
        Image::destroy($image_id);
        return redirect(route('images.index', compact('collection_id')));
    }

    public function show(int $collection_id, int $image_id)
    {
        $image = Image::whereCollectionId($collection_id)->where('id', $image_id)->first();
        if ($image == null) abort(404);
        return view('frontend.images.show', compact('image'));
    }

    public function edit(int $collection_id, int $image_id)
    {
        return view('frontend.images.edit');
    }

    public function update(int $collection_id, int $image_id, ImageFromRequest $request)
    {
        return redirect(route('images.show', compact('collection_id', 'image_id')));
    }
}
