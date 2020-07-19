<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Categorie;
use App\Http\Resources\CategorieResource;
use Illuminate\Support\Facades\Auth;

class CategorieController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Categorie::all();

        // return response
        $response = [
            'success' => true,
            'message' => 'categories retrieved successfully.',
            'data' => CategorieResource::collection($categories),
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
        $validator = Validator::make($input, [
            'name' => 'required|unique:categories'
        ]);

        if($validator->fails()){
            $response = [
                'success' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()->all()
            ];
            return response()->json($response, 400);
        }

        $categorie = Categorie::create($input);

        // return response
        $response = [
            'success' => true,
            'message' => 'Categorie created successfully.',
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
        $categorie = Categorie::find($id);

        if (is_null($categorie)) {
            // return response
            $response = [
                'success' => false,
                'message' => 'categorie not found.',
            ];
            return response()->json($response, 404);
        }

        // return response
        $response = [
            'success' => true,
            'data'    => new CategorieResource($categorie),
            'message' => 'categorie retrieved successfully.',
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
        $categorie = Categorie::find($id);

        $validator = Validator::make($input, [
            'name' => 'required'
        ]);

        if($validator->fails()){
            $response = [
                'success' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()->all()
            ];
            return response()->json($response, 400);
        }


        if (!$categorie) {
            $response = [
                'success' => false,
                'message' => 'Categorie not found',
            ];
            return response()->json($response, 404);
        }

        $categorie->name = $input['name'];
        $categorie->save();

        // return response
        $response = [
            'success' => true,
            'message' => 'categorie updated successfully.'.$categorie->id,
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

        $categorie = Categorie::find($id);
        if (!$categorie) {
            $response = [
                'success' => false,
                'message' => 'Categorie not found',
            ];
            return response()->json($response, 404);
        }

        $categorie->delete();
        // return response
        $response = [
            'success' => true,
            'message' => 'categorie deleted successfully.',
        ];
        return response()->json($response, 200);
    }
}
