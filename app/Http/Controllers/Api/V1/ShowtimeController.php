<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Api\V1\StoreShowtimeRequest;
use App\Http\Requests\Api\V1\UpdateShowtimeRequest;
use App\Http\Resources\Api\V1\ShowtimeResource;
use App\Models\Showtime;

class ShowtimeController extends ApiController
{
    /**
     * Display a listing of showtimes.
     */
    public function index()
    {
        try {
            return $this->successResponseWithData(
                'Showtimes retrieved successfully',
                ShowtimeResource::collection(Showtime::with('movie')->get())
            );
        } catch (\Exception $e) {
            return $this->handleException($e);
        }
    }

    /**
     * Store a newly created showtime in storage.
     */
    public function store(StoreShowtimeRequest $request)
    {
        try {
            $showtime = Showtime::create($request->validated());

            return $this->successResponseWithData(
                'Showtime created successfully',
                new ShowtimeResource($showtime->load('movie')),
                201
            );
        } catch(\Exception $e) {
            return $this->handleException($e);
        }
    }

    /**
     * Display the specified showtime.
     */
    public function show($movieId)
    {
        try {
            $showtime = Showtime::findOrFail($movieId);

            return $this->successResponseWithData(
                'Showtime retrieved successfully',
                new ShowtimeResource($showtime->load('movie'))
            );
        } catch (\Exception $e) {
            return $this->handleException($e);
        }
    }

    /**
     * Update the specified showtime in storage.
     */
    public function update(UpdateShowtimeRequest $request, $movieId)
    {
        try {
            $showtime = Showtime::findOrFail($movieId);
            $showtime->update($request->validated());

            return $this->successResponseWithData(
                'Showtime updated successfully',
                new ShowtimeResource($showtime->load('movie'))
            );
        } catch (\Exception $e) {
            return $this->handleException($e);
        }
    }

    /**
     * Remove the specified showtime from storage.
     */
    public function destroy($movieId)
    {
        try {
            $showtime = Showtime::findOrFail($movieId);
            $showtime->delete();

            return $this->successResponse(
                'Showtime deleted successfully'
            );
        } catch (\Exception $e) {
            return $this->handleException($e);
        }
    }
}
