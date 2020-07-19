<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class HebergementResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'reference' => $this->reference,
            'name' => $this->name,
            'description' => $this->description,
            'adresse1' => $this->adresse1,
            'adresse2' => $this->adresse2,
            'email' => $this->email,
            'telephone' => $this->telephone,
            'website' => $this->website,
            'startTime' => $this->startTime,
            'endTime' =>  $this->endTime,
            'zipcode' => $this->zipcode,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'categorie_id' => $this->categorie_id,
            'city_id' => $this->city_id,
            /*'category' => new CategorieResource($this->categories),
            'city' => new CitieResource($this->cities),*/
            'media' => $this->medias,
            'extra' => $this->hebergements
        ];
    }
}
