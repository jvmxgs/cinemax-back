<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MovieResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'director' => $this->director,
            'release_year' => $this->release_year,
            'genre' => $this->genre,
            'poster' => $this->getFirstMediaUrl('poster'),
            'time_slots' => TimeSlotResource::collection($this->whenLoaded('timeSlots')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
