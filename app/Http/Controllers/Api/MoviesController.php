<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MovieResource;
use App\Models\Movie;
use Illuminate\Http\Request;

class MoviesController extends Controller
{
    public function index(Request $request)
    {
        $movies = Movie::with(['category:id,name'])->latest()->simplePaginate($request->get('limit', 6));

        return MovieResource::collection($movies);
    }

    public function show(Request $request, Movie $movie)
    {
        $movie->load(['category:id,name']);

        return new MovieResource($movie);
    }
}
