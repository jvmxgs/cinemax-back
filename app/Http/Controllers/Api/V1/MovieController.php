<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\StoreMovieRequest;
use App\Http\Requests\Api\V1\UpdateMovieRequest;
use App\Http\Resources\Api\V1\MovieResource;
use App\Models\Movie;
use Illuminate\Http\Response;

class MovieController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return MovieResource::collection(Movie::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMovieRequest $request)
    {
        $movie = Movie::create($request->validated());
        return new MovieResource($movie);
    }

    /**
     * Display the specified resource.
     */
    public function show(Movie $movie)
    {
        return new MovieResource($movie);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMovieRequest $request, Movie $movie)
    {
        $movie->update($request->validated());
        return new MovieResource($movie);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Movie $movie)
    {
        $movie->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
