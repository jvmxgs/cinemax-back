<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Api\V1\StoreTimeSlotRequest;
use App\Http\Requests\Api\V1\UpdateTimeSlotRequest;
use App\Http\Resources\Api\V1\TimeSlotResource;
use App\Models\TimeSlot;

class TimeSlotController extends ApiController
{
    /**
     * Display a listing of time slots.
     */
    public function index()
    {
        try {
            return $this->successResponseWithData(
                'Time slots retrieved successfully',
                TimeSlotResource::collection(TimeSlot::with('movie')->get())
            );
        } catch (\Exception $e) {
            return $this->handleException($e);
        }
    }

    /**
     * Store a newly created time slot in storage.
     */
    public function store(StoreTimeSlotRequest $request)
    {
        try {
            $timeSlot = TimeSlot::create($request->validated());

            return $this->successResponseWithData(
                'Time slot created successfully',
                new TimeSlotResource($timeSlot),
                201
            );
        } catch(\Exception $e) {
            return $this->handleException($e);
        }
    }

    /**
     * Display the specified time slot.
     */
    public function show($movieId)
    {
        try {
            $timeSlot = TimeSlot::findOrFail($movieId);

            return $this->successResponseWithData(
                'Time slot retrieved successfully',
                new TimeSlotResource($timeSlot->load('movie'))
            );
        } catch (\Exception $e) {
            return $this->handleException($e);
        }
    }

    /**
     * Update the specified time slot in storage.
     */
    public function update(UpdateTimeSlotRequest $request, $movieId)
    {
        try {
            $timeSlot = TimeSlot::findOrFail($movieId);
            $timeSlot->update($request->validated());

            return $this->successResponseWithData(
                'TimeSlot updated successfully',
                new TimeSlotResource($timeSlot)
            );
        } catch (\Exception $e) {
            return $this->handleException($e);
        }
    }

    /**
     * Remove the specified time slot from storage.
     */
    public function destroy($movieId)
    {
        try {
            $timeSlot = TimeSlot::findOrFail($movieId);
            $timeSlot->delete();

            return $this->successResponse(
                'Time slot deleted successfully'
            );
        } catch (\Exception $e) {
            return $this->handleException($e);
        }
    }
}
