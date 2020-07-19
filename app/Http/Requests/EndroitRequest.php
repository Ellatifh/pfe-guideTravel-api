<?php

namespace App\Http\Requests;

class EndroitRequest extends ApiFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'description' => 'required|string',
            'adresse1' => 'required|string',
            'adresse2' => 'string',
            'email' => 'nullable|string|email',
            'telephone' => 'nullable|string',
            'website' => 'nullable|string',
            'startTime' => 'string',
            'endTime' => 'required|string',
            'zipcode' => 'required|integer',
            'longitude' => ['required','regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/'],
            'latitude' => ['required','regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/'],
            'categorie_id' => 'required|integer',
            'city_id' => 'required|integer',
            'media'=> 'required|array|min:1|max:5',
            'type' => 'sometimes|required|string',
            'startDate' => 'sometimes|required|date',
            'endDate' => 'sometimes|required|date',
            'ranking' => 'sometimes|required|integer',
            'wifi' => 'sometimes|required|boolean',
            'piscine' => 'sometimes|required|boolean',
            'restaurant' => 'sometimes|required|boolean',
            'spa' => 'sometimes|required|boolean',
            'fitness' => 'sometimes|required|boolean',
            'rooms' => 'sometimes|required|integer',
            'specialite' => 'sometimes|required|string',
            'prixCarte' => 'sometimes|required|integer',
            'prixMoyenne' => 'sometimes|required|integer'
        ];
    }
}
