<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ImageResource;

class InterestingPlaceResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'identificador' => $this->id,
            'name' => $this->name,
            'gps_location' => $this->gps,
            'place_type' => $this->placeType->name,
            'ordre' => $this->pivot->order,
            // Descripció si existeix al model
            'description' => $this->when(isset($this->description) && $this->description !== null, $this->description)
        ];
    }
}

/**
 * Resource para devolver detalles completos de un InterestingPlace,
 * incluyendo descripción y lista de treks asociados.
 */
class InterestingPlaceDetailResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'gps' => $this->gps,
            'gps_location' => $this->gps,
            'placeType' => $this->whenLoaded('placeType', fn () => [
                'id' => $this->placeType->id,
                'name' => $this->placeType->name,
            ]),
            'place_type' => $this->placeType->name,
            'description' => $this->description,
            'treks' => $this->whenLoaded('treks', fn () => 
                $this->treks->map(fn ($trek) => [
                    'id' => $trek->id,
                    'name' => $trek->name,
                    'regNumber' => $trek->regNumber,
                ])
            ),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}

