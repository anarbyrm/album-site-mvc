<?php

namespace App\Helpers\Policy;

use App\Models\Collection;
use Illuminate\Http\Request;

function canUserSeeCollection(Request $request, Collection $collection)
{
    if ($request->user()->cannot('view', $collection)) abort(403);
}
