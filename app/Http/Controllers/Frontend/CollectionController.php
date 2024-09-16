<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        Collection::destroy($id);
        return redirect(route('collections.index'));
    }
}
