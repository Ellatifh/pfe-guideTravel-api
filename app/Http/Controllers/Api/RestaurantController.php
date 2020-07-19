<?php

namespace App\Http\Controllers\Api;

use App\Categorie;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Endroits;
use App\Http\Requests\EndroitRequest;
use App\Http\Resources\RestaurantResource;
use App\Restaurants;
use App\Http\Traits\EndroitTrait;
use Illuminate\Support\Facades\Validator;

class RestaurantController extends Controller
{
    use EndroitTrait;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api')->except('index');
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category = Categorie::where('name','Restaurants')->first()!= null ? Categorie::where('name','Restaurants')->first()->id : 0;
        $restaurants = Endroits::where('categorie_id',$category)->with('restaurants')->get();

        // return response
        $response = [
            'success' => true,
            'message' => 'restaurants retrieved successfully.',
            'data' => RestaurantResource::collection($restaurants),
        ];
        return response()->json($response, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EndroitRequest $request)
    {
        $input = $request->all();

        $endroit = $this->saveEndroit($input);

        Restaurants::create(
            [
                'endroits_reference'=>$endroit->reference,
                'type'=>$input["type"],
                'specialite'=>$input["specialite"],
                'prixCarte'=>$input["prixCarte"],
                'prixMoyenne'=>$input["prixMoyenne"]
            ]
        );

        // return response
        $response = [
            'success' => true,
            'message' => 'restaurant created successfully.',
        ];

        return response()->json($response, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $endroit = $this->showEndroit($id,"Restaurants");

        if($endroit){
            $restaurant = $endroit->with('hebergements')->get();

            // return response
            $response = [
                'success' => true,
                'data'    => new RestaurantResource($restaurant),
                'message' => 'restaurant retrieved successfully.',
            ];
            return response()->json($response, 200);
        }
        $response = [
            'success' => false,
            'message' => 'restaurant not found.',
        ];
        return response()->json($response, 404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $input = $request->all();
        $this->updateEndroit($input,$id);
        Restaurants::where('endroits_reference',$id)->update(
            [
                'type'=>$input["type"],
                'specialite'=>$input["specialite"],
                'prixCarte'=>$input["prixCarte"],
                'prixMoyenne'=>$input["prixMoyenne"]
            ]
        );

        // return response
        $response = [
            'success' => true,
            'message' => 'restaurant updated successfully.',
        ];
        return response()->json($response, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->deleteEndroit($id,"Restaurants");
    }
}
