<?php
namespace App\Http\Traits;

use App\Categorie;
use App\Endroits;
use App\Media;
use Illuminate\Support\Facades\Auth;

trait EndroitTrait {

    public function saveEndroit($input)
    {
        $this->authorize('isAdmin');
        $arr = [explode(" ", $input["name"], 2)[0],$input["categorie_id"],$input["city_id"],strtotime(date("Y-m-dH:i:s", time()))];
        $reference = implode("-",$arr);
        $endroit = Endroits::create(
            [
            'reference' => $reference,
            'name'=> $input["name"],
            'description'=> $input["description"],
            'adresse1'=> $input["adresse1"],
            'adresse2'=> $input["adresse2"],
            'email'=> $input["email"],
            'telephone'=> $input["telephone"],
            'website'=> $input["website"],
            'startTime'=> $input["startTime"],
            'endTime'=> $input["endTime"],
            'zipcode'=> $input["zipcode"],
            'longitude'=> $input["longitude"],
            'latitude'=> $input["latitude"],
            'categorie_id'=> $input["categorie_id"],
            'city_id'=> $input["city_id"],
            'user_id'=> Auth::user()->id
            ]
        );
        if(array_key_exists('media',$input)){
            $this->savePictures($reference,$input['media']);
        }
        return $endroit;
    }

    public function updateEndroit($input,$id)
    {
        $endroit = Endroits::where('reference',$id);
        $this->authorize('isOwner',$endroit);

        if($endroit){
            $endroit->update(
                [
                    'name'=> $input["name"],
                    'description'=> $input["description"],
                    'adresse1'=> $input["adresse1"],
                    'adresse2'=> $input["adresse2"],
                    'email'=> $input["email"],
                    'telephone'=> $input["telephone"],
                    'website'=> $input["website"],
                    'startTime'=> $input["startTime"],
                    'endTime'=> $input["endTime"],
                    'zipcode'=> $input["zipcode"],
                    'longitude'=> $input["longitude"],
                    'latitude'=> $input["latitude"],
                    'categorie_id'=> $input["categorie_id"],
                    'city_id'=> $input["city_id"]
                ]
            );
            if(array_key_exists('media',$input)){
               $this->savePictures($id,$input['media']);
            }
            return $endroit;
        }

        return null;
    }

    public function showEndroit($id,$category_name)
    {
        $selectedCategory = Categorie::where('name',$category_name)->first();
        $category = $selectedCategory!= null ? $selectedCategory->id : 0;
        $endroit = Endroits::where('reference',$category)->where('reference',$id);
        $this->authorize('isOwner',$endroit);
        if($endroit){
            return $endroit;
        }

        return null;
    }

    public function deleteEndroit($id,$category_name)
    {
        $selectedCategory = Categorie::where('name',$category_name)->first();
        $category = $selectedCategory!= null ? $selectedCategory->id : 0;
        $endroit = Endroits::where(['categorie_id'=>$category,'reference'=>$id]);

        if (!$endroit) {
            $response = [
                'success' => false,
                'message' => 'Endroit not found',
            ];
            return response()->json($response, 404);
        }
        $endroit->delete();

        // return response
        $response = [
            'success' => true,
            'message' => 'Endroit deleted successfully.',
        ];
        return response()->json($response, 200);
    }

    public function savePictures($reference,$picutres){
        if(is_array($picutres) && count($picutres)>0){
            Media::where('endroits_reference',$reference)->delete();
            foreach ($picutres as $value) {
                Media::create([
                    'endroits_reference'=>$reference,
                    'path' => $value['path'],
                    'type' => 'base64'
                ]);
            }
        }
    }

}
