<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\ImageFromRequest;
use App\Http\Requests\ImageUpdateFormRequest;
use App\Models\Collection;
use App\Models\Image;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;

use function App\Helpers\Policy\canUserSeeCollection;
use function Illuminate\Filesystem\join_paths;

class ImageController extends Controller
{
    public function index(int $collection_id)
    {
        $collection = Collection::findOrFail($collection_id);
        // check if user owns the collection
        canUserSeeCollection(request(), $collection);

        $images = $collection->images()->get();
        return view('frontend.images.index', compact('images', 'collection_id'));
    }

    public function create(int $collection_id)
    {
        return view('frontend.images.create', compact('collection_id'));
    }

    public function store(int $collection_id, ImageFromRequest $request)
    {
        $validatedData = $request->validated();
        $collection = Collection::findOrFail($collection_id);
        
        // check if user owns the collection
        canUserSeeCollection(request(), $collection);

        $filePath = $this->_uploadImageAndGetFilePath($validatedData['image']);
        $validatedData['url'] = $filePath;

        $collection->images()->create($validatedData);
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
        return $fileName . '-' .$currentDateTime . '.' . $mimeType;
    }

    public function delete(int $collection_id, int $image_id)
    {
        $image = $this->_findCollectionImageWithIdOrFail($collection_id, $image_id);
        $imagePath = $image->url;
        $deleteResult = Image::destroy($image->id);

        // remove old photo after successful deletion
        if ($deleteResult > 0) $this->_removeImage($imagePath);
        return redirect(route('images.index', compact('collection_id')));
    }

    public function show(int $collection_id, int $image_id)
    {
        $image = $this->_findCollectionImageWithIdOrFail($collection_id, $image_id);
        return view('frontend.images.show', compact('collection_id', 'image'));
    }

    public function edit(int $collection_id, int $image_id)
    {
        $image = $this->_findCollectionImageWithIdOrFail($collection_id, $image_id);
        return view('frontend.images.edit', compact('collection_id', 'image'));
    }

    private function _findCollectionImageWithIdOrFail(int $collection_id, int $image_id)
    {
        $image = Image::whereCollectionId($collection_id)->where('id', $image_id)->first();

        // check if user owns the collection
        canUserSeeCollection(request(), $image->collection()->get());

        if ($image == null) abort(404);
        return $image;
    }

    public function update(int $collection_id, int $image_id, ImageUpdateFormRequest $request)
    {
        $validatedData = $request->validated();
        $oldImagePath = null;
        $image = $this->_findCollectionImageWithIdOrFail($collection_id, $image_id);

        if (isset($validatedData['image'])) {
            $filePath = $this->_uploadImageAndGetFilePath($validatedData['image']);
            $oldImagePath = $image->url;
            $validatedData['url'] = $filePath;
        }

        $image->update($validatedData);
        // remove old photo after success
        if ($oldImagePath != null) $this->_removeImage($oldImagePath);
        return redirect(route('images.show', compact('collection_id', 'image_id')));
    }

    private function _removeImage(string $path)
    {
        $fullImagePath = join_paths(storage_path('app/public'), $path);
        unlink($fullImagePath);
    }
}
