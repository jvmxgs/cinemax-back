<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Api\V1\StoreMovieRequest;
use App\Http\Requests\Api\V1\UpdateMovieRequest;
use App\Http\Resources\Api\V1\MovieResource;
use App\Models\Movie;
use Illuminate\Http\Response;

class MovieController extends ApiController
{
    /**
     * Display a listing of movies.
     */
    public function index()
    {
        try {
            return $this->successResponseWithData(
                'Movies retrieved successfully',
                MovieResource::collection(Movie::all())
            );
        } catch (\Exception $e) {
            return $this->handleException($e);
        }
    }

    /**
     * Store a newly created movie in storage.
     */
    public function store(StoreMovieRequest $request)
    {
        try {
            $movie = Movie::create($request->validated());

            return $this->successResponseWithData(
                'Movie created successfully',
                new MovieResource($movie),
                201
            );
        } catch(\Exception $e) {
            return $this->handleException($e);
        }
    }

    /**
     * Display the specified movie.
     */
    public function show($movie)
    {
        try {
            $movie = Movie::findOrFail($movie);

            return $this->successResponseWithData(
                'Movie retrieved successfully',
                new MovieResource($movie)
            );
        } catch (\Exception $e) {
            return $this->handleException($e);
        }
    }

    /**
     * Update the specified movie in storage.
     */
    public function update(UpdateMovieRequest $request, $movie)
    {
        try {
            $movie = Movie::findOrFail($movie);
            $movie->update($request->validated());

            return $this->successResponseWithData(
                'Movie updated successfully',
                new MovieResource($movie)
            );
        } catch (\Exception $e) {
            return $this->handleException($e);
        }
    }

    /**
     * Remove the specified movie from storage.
     */
    public function destroy($movie)
    {
        try {
            $movie = Movie::findOrFail($movie);
            $movie->delete();

            return $this->successResponse(
                'Movie deleted successfully'
            );
        } catch (\Exception $e) {
            return $this->handleException($e);
        }
    }
}
