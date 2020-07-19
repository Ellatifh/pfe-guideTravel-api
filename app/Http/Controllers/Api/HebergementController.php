<?php

namespace App\Http\Controllers\Api;

use App\Categorie;
use App\Endroits;
use App\Hebergements;
use App\Http\Controllers\Controller;
use App\Http\Requests\EndroitRequest;
use App\Http\Resources\HebergementResource;
use App\Http\Traits\EndroitTrait;
use App\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HebergementController extends Controller
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
        $category = Categorie::where('name','Hebergements')->first()!= null ? Categorie::where('name','Hebergements')->first()->id : 0;
        $Hebergements = Endroits::where('categorie_id',$category)->with('hebergements')->get();

        // return response
        $response = [
            'success' => true,
            'message' => 'Hebergements retrieved successfully.',
            'data' => HebergementResource::collection($Hebergements),
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

        Hebergements::create(
            [
                'endroits_reference'=> $endroit->reference,
                'type'=>in_array("type",$input) ? $input["type"] : false,
                'ranking'=>in_array("ranking",$input) ? $input["ranking"] : false,
                'wifi'=>in_array("wifi",$input) ? $input["wifi"] : false,
                'piscine'=>in_array("piscine",$input) ? $input["piscine"] : false,
                'restaurant'=>in_array("restaurant",$input) ? $input["restaurant"] : false,
                'spa'=>in_array("spa",$input) ? $input["spa"] : false,
                'fitness'=>in_array("fitness",$input) ? $input["fitness"] : false,
                'rooms'=>$input["rooms"],
            ]
        );

        // return response
        $response = [
            'success' => true,
            'message' => 'hebergement created successfully.',
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
        $endroit = $this->showEndroit($id,'Hebergements');

        if($endroit){
            $hebergement = $endroit->with('hebergements')->get();

            // return response
            $response = [
                'success' => true,
                'data'    => $hebergement,
                'message' => 'hebergement retrieved successfully.',
            ];
            return response()->json($response, 200);
        }
        $response = [
            'success' => false,
            'message' => 'hebergement not found.',
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

        Hebergements::where('endroits_reference',$id)->update(
            [
                'type'=>$input["type"],
                'ranking'=>$input["ranking"],
                'wifi'=>$input["wifi"],
                'piscine'=>$input["piscine"],
                'restaurant'=>$input["restaurant"],
                'spa'=>$input["spa"],
                'fitness'=>$input["fitness"],
                'rooms'=>$input["rooms"],
            ]
        );

        // return response
        $response = [
            'success' => true,
            'message' => 'hebergement updated successfully.',
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
        $this->deleteEndroit($id,'Hebergements');
    }
}
