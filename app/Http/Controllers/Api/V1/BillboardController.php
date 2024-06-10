<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\Api\V1\TimeSlotResource;
use App\Models\TimeSlot;

class BillboardController extends ApiController
{
    /**
     * Display a listing of time slots.
     */
    public function index()
    {
        try {
            $timeslotResouce = TimeSlotResource::collection(
                TimeSlot::with('movie')
                    ->whereHas('movie')
                    ->orderBy('start_time', 'asc')
                    ->get()
            );

            return $this->successResponseWithData(
                'Time slots retrieved successfully',
                $timeslotResouce->response()->getData(true)
            );
        } catch (\Exception $e) {
            return $this->handleException($e);
        }
    }
}
