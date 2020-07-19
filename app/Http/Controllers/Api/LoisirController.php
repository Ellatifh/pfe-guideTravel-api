<?php

namespace App\Http\Controllers\Api;

use App\Categorie;
use App\Endroits;
use App\Http\Controllers\Controller;
use App\Http\Requests\EndroitRequest;
use App\Http\Resources\LoisirResource;
use App\Http\Traits\EndroitTrait;
use App\Loisir;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class LoisirController extends Controller
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
        $category = Categorie::where('name','Loisirs')->first()!= null ? Categorie::where('name','Loisirs')->first()->id : 0;
        $loisirs = Endroits::where('categorie_id',$category)->with('loisir')->get();

        // return response
        $response = [
            'success' => true,
            'message' => 'loisirs retrieved successfully.',
            'data' => LoisirResource::collection($loisirs),
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

        Loisir::create(
            [
                'endroits_reference'=>$endroit->reference,
                'type'=>$input["type"]
            ]
        );

        // return response
        $response = [
            'success' => true,
            'message' => 'hobbie created successfully.',
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
        $endroit = $this->showEndroit($id,"Loisirs");

        if($endroit){
            $endroit = $endroit->with('loisirs')->get();

            // return response
            $response = [
                'success' => true,
                'data'    => new LoisirResource($endroit),
                'message' => 'hobbie retrieved successfully.',
            ];
            return response()->json($response, 200);
        }
        $response = [
            'success' => false,
            'message' => 'hobbie not found.',
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
        $endroit = $this->updateEndroit($input,$id);
        Loisir::where('endroits_reference',$id)->update(['type'=>$input["type"]]);

        // return response
        $response = [
            'success' => true,
            'message' => 'hobbie updated successfully.',
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
        $this->deleteEndroit($id,"Loisirs");
    }
}
