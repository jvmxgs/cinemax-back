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
            $timeslotResouce = TimeSlotResource::collection(
                TimeSlot::with('movie')->orderBy('created_at', 'desc')->paginate(10)
            );

            return $this->successResponseWithData(
                'Time slots retrieved successfully',
                $timeslotResouce->response()->getData(true)
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
            $timeSlot = TimeSlot::with('movie')->create($request->validated());

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
    public function show($timeSlotId)
    {
        try {
            $timeSlot = TimeSlot::with('movie')->findOrFail($timeSlotId);

            return $this->successResponseWithData(
                'Time slot retrieved successfully',
                new TimeSlotResource($timeSlot)
            );
        } catch (\Exception $e) {
            return $this->handleException($e);
        }
    }

    /**
     * Update the specified time slot in storage.
     */
    public function update(UpdateTimeSlotRequest $request, $timeSlotId)
    {
        try {
            $timeSlot = TimeSlot::with('movie')->findOrFail($timeSlotId);
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
    public function destroy($timeSlotId)
    {
        try {
            $timeSlot = TimeSlot::findOrFail($timeSlotId);
            $timeSlot->delete();

            return $this->successResponse(
                'Time slot deleted successfully'
            );
        } catch (\Exception $e) {
            return $this->handleException($e);
        }
    }
}
