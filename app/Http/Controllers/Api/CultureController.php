<?php

namespace App\Http\Controllers\Api;

use App\Categorie;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Cultures;
use App\Endroits;
use App\Http\Requests\EndroitRequest;
use App\Http\Resources\CultureResource;
use App\Http\Traits\EndroitTrait;
use App\Media;
use Illuminate\Support\Facades\Validator;

class CultureController extends Controller
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
        $category = Categorie::where('name','Cultures')->first()!= null ? Categorie::where('name','Cultures')->first()->id : 0;
        $cultures = Endroits::where('categorie_id',$category)->with('cultures')->get();

        // return response
        $response = [
            'success' => true,
            'message' => 'cultures retrieved successfully.',
            'data' => CultureResource::collection($cultures),
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

        cultures::create(
            [
                'endroits_reference'=>$endroit->reference,
                'type'=>$input["type"]
            ]
        );

        // return response
        $response = [
            'success' => true,
            'message' => 'culture created successfully.',
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
        $endroit = $this->showEndroit($id,'Cultures');

        if($endroit){
            $culture = $endroit->with('cultures')->get();

            // return response
            $response = [
                'success' => true,
                'data'    => new CultureResource($culture),
                'message' => 'culture retrieved successfully.',
            ];
            return response()->json($response, 200);
        }
        $response = [
            'success' => false,
            'message' => 'culture not found.',
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
        Cultures::where('endroits_reference',$id)->update(['type'=>$input["type"]]);

        // return response
        $response = [
            'success' => true,
            'message' => 'culture updated successfully.',
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
        $this->deleteEndroit($id,'Cultures');
    }
}
