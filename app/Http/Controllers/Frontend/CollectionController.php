<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

use function App\Helpers\Policy\canUserSeeCollection;
use function Illuminate\Filesystem\join_paths;

class CollectionController extends Controller
{
    public function index()
    {
        $collections = Collection::where('user_id', Auth::id())
            ->withCount('images')
            ->get();
        return view('frontend.collections.index', compact('collections'));
    }

    public function create()
    {
        return view('frontend.collections.create');
    }

    public function store(Request $request)
    {
        Collection::create([
            'name' => $request->name,
            'user_id' => Auth::id(),
        ]);
        return redirect(route('collections.index'));
    }

    public function delete(int $id)
    {
        
        $collection = Collection::findOrFail($id);
        // check if user owns the collection
        canUserSeeCollection(request(), $collection);

        $images = $collection->images()->get();
        $imagePaths = $this->_getImagePaths($images);

        $collection->delete(); // cascade delete with image entities

        // remove images from server after successful deletion
        $this->_deleteImages($imagePaths);
        return redirect(route('collections.index'));
    }

    private function _getImagePaths(EloquentCollection $images)
    {
        $result = [];
        foreach ($images as $image) $result[] = $image->url;
        return $result;
    }

    private function _deleteImages(array $imagePaths) 
    {
        foreach ($imagePaths as $path) {
            $fullPath = join_paths(storage_path('app/public'), $path);
            unlink($fullPath);
        }
    }
}
