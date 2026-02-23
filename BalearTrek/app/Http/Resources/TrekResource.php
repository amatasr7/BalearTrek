<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;
use App\Http\Resources\MeetingResource;
use App\Http\Resources\InterestingPlaceResource;


class TrekResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [  
            'identificador' => $this->id,
            'registre' => $this->regNumber,
            'nom' => $this->name,
            // Descripció: si existeix a la BDD l'usarà; si no, fem un fallback
            'description' => $this->when(isset($this->description) && $this->description !== null, $this->description) ?? ($this->whenLoaded('interestingPlaces') ? 'Inclou llocs: ' . $this->interestingPlaces->pluck('name')->join(', ') : null),
            'municipi' => $this->municipality->name,
            'llocsInteressants' => InterestingPlaceResource::collection($this->whenLoaded('interestingPlaces')),
            'reunions' => MeetingResource::collection($this->whenLoaded('meetings')),
        ];
    }
}
