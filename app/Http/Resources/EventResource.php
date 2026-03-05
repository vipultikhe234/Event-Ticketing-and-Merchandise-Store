<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'date' => $this->date->toDateString(),
            'time' => $this->time,
            'venue' => $this->venue,
            'ticket_price' => $this->ticket_price,
            'performers' => $this->performers->map(function ($p) {
                return [
                    'id' => $p->id,
                    'name' => $p->name,
                    'bio' => $p->bio,
                    'spotify_id' => $p->spotify_id
                ];
            }),
        ];
    }
}
