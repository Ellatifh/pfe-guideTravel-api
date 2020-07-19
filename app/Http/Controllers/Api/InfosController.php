<?php

namespace App\Http\Controllers\Api;

use App\Categorie;
use App\Endroits;
use App\Http\Controllers\Controller;
use App\Http\Requests\EndroitRequest;
use App\Http\Traits\EndroitTrait;
use App\Infos;
use Illuminate\Http\Request;
use App\Http\Resources\InfosResource;


class InfosController extends Controller
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
        $category = Categorie::where('name','Infos')->first()!= null ? Categorie::where('name','Infos')->first()->id : 0;
        $infos = Endroits::where('categorie_id',$category)->with('infos')->get();

        // return response
        $response = [
            'success' => true,
            'message' => 'infos retrieved successfully.',
            'data' => InfosResource::collection($infos),
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

        Infos::create(
            [
                'endroits_reference'=>$endroit->reference,
                'type'=>$input["type"]
            ]
        );

        // return response
        $response = [
            'success' => true,
            'message' => 'infos created successfully.',
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
        $endroit = $this->showEndroit($id,'infos');

        if($endroit){
            $infos = $endroit->with('infos')->get();

            // return response
            $response = [
                'success' => true,
                'data'    => new InfosResource($infos),
                'message' => 'infos retrieved successfully.',
            ];
            return response()->json($response, 200);
        }
        $response = [
            'success' => false,
            'message' => 'infos not found.',
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
        infos::where('endroits_reference',$id)->update(['type'=>$input["type"]]);

        // return response
        $response = [
            'success' => true,
            'message' => 'infos updated successfully.',
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
        $this->deleteEndroit($id,'infos');
    }
}
