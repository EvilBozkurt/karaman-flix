<?php

namespace App\Http\Controllers\Admin;

use App\Actions\UploadFile;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\MovieResource;
use App\Models\Category;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class MoviesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $movies = Movie::with(['category:id,name'])->latest()->simplePaginate(10);

        return Inertia::render('Movies/Index', [
            'movies' => MovieResource::collection($movies),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Movies/Create', [
            'edit' => false,
            'movie' => new MovieResource(new Movie()),
            'categories' => CategoryResource::collection(Category::select(['id', 'name'])->get()),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, UploadFile $uploadFile)
    {
        $data = $request->validate([
            'category_id' => ['required', Rule::exists(Category::class, 'id')],
            'title' => ['required', 'string', 'max:255'],
            'trailer' => ['required', 'string', 'max:255'],
            'year' => ['required', 'string', 'max:4', 'min:4'],
            'slug' => ['required', 'string', Rule::unique(Movie::class)],
            'image' => ['required', 'image', 'max:3000'],
            'description' => ['required', 'string'],
        ]);

        $data['image'] = $uploadFile->setFile($request->file('image'))
            ->setUploadPath((new Movie())->uploadFolder())
            ->execute();

        Movie::create($data);

        return redirect()->route('movies.index')->with('success', 'Movie saved successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function show(Movie $movie)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function edit(Movie $movie)
    {
        return Inertia::render('Movies/Create', [
            'edit' => true,
            'movie' => new MovieResource($movie),
            'categories' => CategoryResource::collection(Category::select(['id', 'name'])->get()),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Movie $movie, UploadFile $uploadFile)
    {
        $data = $request->validate([
            'category_id' => ['required', Rule::exists(Category::class, 'id')],
            'title' => ['required', 'string', 'max:255'],
            'trailer' => ['required', 'string', 'max:255'],
            'year' => ['required', 'string', 'max:4', 'min:4'],
            'slug' => ['required', 'string', Rule::unique(Movie::class)->ignore($movie->id)],
            'image' => ['nullable', 'image', 'max:3000'],
            'description' => ['required', 'string'],
        ]);

        $data['image'] = $movie->image;
        if ($request->file('image')) {
            $movie->deleteImage();

            $data['image'] = $uploadFile->setFile($request->file('image'))
                ->setUploadPath($movie->uploadFolder())
                ->execute();
        }

        $movie->update($data);

        return redirect()->route('movies.index')->with('success', 'Movie updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function destroy(Movie $movie)
    {
        $movie->deleteImage();
        $movie->delete();

        return redirect()->route('movies.index')
            ->with('success', 'Movie deleted successfully.');
    }
}
