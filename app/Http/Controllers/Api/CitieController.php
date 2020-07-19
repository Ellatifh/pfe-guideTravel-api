<?php

namespace App\Http\Controllers\Api;

use App\Categorie;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Citie;
use App\Cultures;
use App\Endroits;
use App\Http\Resources\CitieResource;
use App\Http\Resources\CultureResource;
use App\Http\Resources\EventResource;
use App\Http\Resources\HebergementResource;
use App\Http\Resources\InfosResource;
use App\Http\Resources\LoisirResource;
use App\Http\Resources\RestaurantResource;
use App\Http\Resources\ShoppingResource;

class CitieController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api')->except(['events','hebergements','cultures','infos','loisirs','restaurants','shoppings']);
    }

         /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function events($id)
    {
        $category = Categorie::where('name','Events')->first()!= null ? Categorie::where('name','Events')->first()->id : 0;
        $events = Endroits::where('categorie_id',$category)->where('city_id',$id)->with('events')->get();

        // return response
        $response = [
            'success' => true,
            'message' => 'Events retrieved successfully.',
            'data' => EventResource::collection($events),
        ];
        return response()->json($response, 200);
    }

         /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function hebergements($id)
    {
        $category = Categorie::where('name','Hebergements')->first()!= null ? Categorie::where('name','Hebergements')->first()->id : 0;
        $Hebergements = Endroits::where('categorie_id',$category)->where('city_id',$id)->with('hebergements')->get();

        // return response
        $response = [
            'success' => true,
            'message' => 'Hebergements retrieved successfully.',
            'data' => HebergementResource::collection($Hebergements),
        ];
        return response()->json($response, 200);
    }

         /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function cultures($id)
    {
        $category = Categorie::where('name','Cultures')->first()!= null ? Categorie::where('name','Cultures')->first()->id : 0;
        $cultures = Endroits::where('categorie_id',$category)->where('city_id',$id)->with('cultures')->get();

        // return response
        $response = [
            'success' => true,
            'message' => 'cultures retrieved successfully.',
            'data' => CultureResource::collection($cultures),
        ];
        return response()->json($response, 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function infos($id)
    {
        $category = Categorie::where('name','Infos')->first()!= null ? Categorie::where('name','Cultures')->first()->id : 0;
        $infos = Endroits::where('categorie_id',$category)->where('city_id',$id)->with('infos')->get();

        // return response
        $response = [
            'success' => true,
            'message' => 'infos retrieved successfully.',
            'data' => InfosResource::collection($infos),
        ];
        return response()->json($response, 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function loisirs($id)
    {
        $category = Categorie::where('name','Loisirs')->first()!= null ? Categorie::where('name','Loisirs')->first()->id : 0;
        $loisirs = Endroits::where('categorie_id',$category)->where('city_id',$id)->with('loisir')->get();

        // return response
        $response = [
            'success' => true,
            'message' => 'loisirs retrieved successfully.',
            'data' => LoisirResource::collection($loisirs),
        ];
        return response()->json($response, 200);
    }

        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function restaurants($id)
    {
        $category = Categorie::where('name','Restaurants')->first()!= null ? Categorie::where('name','Restaurants')->first()->id : 0;
        $restaurants = Endroits::where('categorie_id',$category)->where('city_id',$id)->with('restaurants')->get();

        // return response
        $response = [
            'success' => true,
            'message' => 'Restaurants retrieved successfully.',
            'data' => RestaurantResource::collection($restaurants),
        ];
        return response()->json($response, 200);
    }

            /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function shoppings($id)
    {
        $category = Categorie::where('name','Shoppings')->first()!= null ? Categorie::where('name','Shoppings')->first()->id : 0;
        $shoppings = Endroits::where('categorie_id',$category)->where('city_id',$id)->with('shoppings')->get();

        // return response
        $response = [
            'success' => true,
            'message' => 'shoppings retrieved successfully.',
            'data' => ShoppingResource::collection($shoppings),
        ];
        return response()->json($response, 200);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cities = Citie::all();

        // return response
        $response = [
            'success' => true,
            'message' => 'cities retrieved successfully.',
            'data' => CitieResource::collection($cities),
        ];
        return response()->json($response, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('isAdmin');

        $input = $request->all();

        $this->validate($request, [
            'name' => 'required|unique:cities'
        ]);


        $citie = Citie::create($input);

        // return response
        $response = [
            'success' => true,
            'message' => 'citie created successfully.',
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
        $citie = Citie::find($id);

        if (is_null($citie)) {
            // return response
            $response = [
                'success' => false,
                'message' => 'citie not found.',
            ];
            return response()->json($response, 404);
        }

        // return response
        $response = [
            'success' => true,
            'data'    => new CitieResource($citie),
            'message' => 'citie retrieved successfully.',
        ];
        return response()->json($response, 200);
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
        $this->authorize('isAdmin');

        $input = $request->all();
        $citie = Citie::find($id);

        $this->validate($request, [
            'name' => 'required'
        ]);


        if (!$citie) {
            $response = [
                'success' => false,
                'message' => 'Citie not found',
            ];
            return response()->json($response, 404);
        }

        $citie->name = $input['name'];
        $citie->save();

        // return response
        $response = [
            'success' => true,
            'message' => 'citie updated successfully.',
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
        $this->authorize('isAdmin');
        $citie = Citie::find($id);

        if (!$citie) {
            $response = [
                'success' => false,
                'message' => 'Citie not found',
            ];
            return response()->json($response, 404);
        }
        $citie->delete();

        // return response
        $response = [
            'success' => true,
            'message' => 'citie deleted successfully.',
        ];
        return response()->json($response, 200);
    }
}
