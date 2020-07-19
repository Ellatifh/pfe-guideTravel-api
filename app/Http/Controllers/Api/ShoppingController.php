<?php

namespace App\Http\Controllers\Api;

use App\Categorie;
use App\Endroits;
use App\Http\Controllers\Controller;
use App\Http\Requests\EndroitRequest;
use App\Http\Resources\ShoppingResource;
use App\Http\Traits\EndroitTrait;
use App\Shoppings;

class ShoppingController extends Controller
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
        $category = Categorie::where('name','Shoppings')->first()!= null ? Categorie::where('name','Shoppings')->first()->id : 0;
        $shoppings = Endroits::where('categorie_id',$category)->with('shoppings')->get();

        // return response
        $response = [
            'success' => true,
            'message' => 'shoppings retrieved successfully.',
            'data' => ShoppingResource::collection($shoppings),
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

        Shoppings::create(
            [
                'endroits_reference'=>$endroit->reference,
                'type'=>$input["type"]
            ]
        );

        // return response
        $response = [
            'success' => true,
            'message' => 'endroit created successfully.',
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
        $endroit = $this->showEndroit($id,"Shoppings");
        if($endroit){
            $endroit = $endroit->with('Shopping')->get();

            // return response
            $response = [
                'success' => true,
                'data'    => new ShoppingResource($endroit),
                'message' => 'endroit retrieved successfully.',
            ];
            return response()->json($response, 200);
        }
        $response = [
            'success' => false,
            'message' => 'endroit not found.',
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
    public function update(EndroitRequest $request,$id)
    {
        $input = $request->all();
        $endroit = $this->updateEndroit($input,$id);
        Shoppings::where('endroits_reference',$id)->update([
            'type'=>$input["type"]
        ]);

        // return response
        $response = [
            'success' => true,
            'message' => 'endroit updated successfully.',
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
        $this->deleteEndroit($id,"Shoppings");
    }
}
