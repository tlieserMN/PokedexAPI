<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pokemon;
use App\TrainerCapture;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PokedexController extends Controller
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

    public function get($id = null){
        //return Pokemon::select('id', 'names', DB::raw('types->>"$.status.name" as types'))->where('id', $id)->get();
        if($id != null){
            $data = Pokemon::find($id);
            if($data){
                // substr($data-types, 1, -1) removes the brackets
                // str_replace('"', '', substr($data->types, 1, -1)) removes all "
                // explode(",", str_replace('"', '', substr($data->types, 1, -1))) breaks into array
                $types = explode(",", str_replace('"', '', substr($data->types, 1, -1)));
                $abilities = explode(",", str_replace('"', '', substr($data->abilities, 1, -1)));
                $egg_groups = explode(",", str_replace('"', '', substr($data->egg_groups, 1, -1)));
                $json = json_encode(array('id' => $data->id, 'names' => $data->names, 'types' => $types, 'height' => $data->height, 'weight' => $data->weight, 'abilities' => $abilities, 'egg_groups' => $egg_groups, 'stats' => json_decode($data->stats), 'genus', $data->genus, 'description' => $data->description));
                return $json;
            }
            else{
                return "error";
            }
        }
        else{
            $data = Pokemon::all();
            $response_data = array();
            for($i = 0; $i < count($data); $i++){
                // substr($data-types, 1, -1) removes the brackets
                // str_replace('"', '', substr($data->types, 1, -1)) removes all "
                // explode(",", str_replace('"', '', substr($data->types, 1, -1))) breaks into array
                $types = explode(",", str_replace('"', '', substr($data[$i]->types, 1, -1)));
                $abilities = explode(",", str_replace('"', '', substr($data[$i]->abilities, 1, -1)));
                $egg_groups = explode(",", str_replace('"', '', substr($data[$i]->egg_groups, 1, -1)));
                $json = array('id' => $data[$i]->id, 'names' => $data[$i]->names, 'types' => $types, 'height' => $data[$i]->height, 'weight' => $data[$i]->weight, 'abilities' => $abilities, 'egg_groups' => $egg_groups, 'stats' => json_decode($data[$i]->stats), 'genus', $data[$i]->genus, 'description' => $data[$i]->description);
                array_push($response_data, $json);
            }
            return json_encode($response_data);
        }
    }

    public function capture(Request $request){
        if($request->input('id')){
            $pokemon = new TrainerCapture();
            $pokemon->pokemon_id = $request->input('id');
            $pokemon->trainer_id = Auth::id();
            $pokemon->save();
            return "success";
        }
        else{
            return "error";
        }
    }

    public function captured(){
        //$pokemon = TrainerCapture::has("trainers")->get();

        $data = DB::select('CALL GetCapturedPokemonForTrainer(?)',array(Auth::id()));
        $response_data = array();
        for($i = 0; $i < count($data); $i++){
            // substr($data-types, 1, -1) removes the brackets
            // str_replace('"', '', substr($data->types, 1, -1)) removes all "
            // explode(",", str_replace('"', '', substr($data->types, 1, -1))) breaks into array
            $types = explode(",", str_replace('"', '', substr($data[$i]->types, 1, -1)));
            $abilities = explode(",", str_replace('"', '', substr($data[$i]->abilities, 1, -1)));
            $egg_groups = explode(",", str_replace('"', '', substr($data[$i]->egg_groups, 1, -1)));
            $json = array('id' => $data[$i]->id, 'names' => $data[$i]->names, 'types' => $types, 'height' => $data[$i]->height, 'weight' => $data[$i]->weight, 'abilities' => $abilities, 'egg_groups' => $egg_groups, 'stats' => json_decode($data[$i]->stats), 'genus', $data[$i]->genus, 'description' => $data[$i]->description);
            array_push($response_data, $json);
        }
        return json_encode($response_data);
    }

    public function update(Request $request){
        if($request->input('id')){
            $pokemon = Pokemon::find($request->input('id'));
            if($pokemon){
                if($request->input('names')){
                    $pokemon->names = $request->input('names');
                }
                if($request->input('types')){
                    $pokemon->types = $request->input('types');
                }
                if($request->input('height')){
                    $pokemon->height = $request->input('height');
                }
                if($request->input('weight')){
                    $pokemon->weight = $request->input('weight');
                }
                if($request->input('abilities')){
                    $pokemon->abilities = $request->input('abilities');
                }
                if($request->input('egg_groups')){
                    $pokemon->egg_groups = $request->input('egg_groups');
                }
                if($request->input('stats')){
                    $pokemon->stats = $request->input('stats');
                }
                if($request->input('genus')){
                    $pokemon->genus = $request->input('genus');
                }
                if($request->input('description')){
                    $pokemon->description = $request->input('description');
                }
                $pokemon->save();
                return "success";
            }
            else{
                return "error";
            }
        }
        else{
            return "error";
        }
    }

    public function create(Request $request){
        $pokemon = new Pokemon();
        if($request->input('names')){
            $pokemon->names = $request->input('names');
        }
        if($request->input('types')){
            $pokemon->types = $request->input('types');
        }
        if($request->input('height')){
            $pokemon->height = $request->input('height');
        }
        if($request->input('weight')){
            $pokemon->weight = $request->input('weight');
        }
        if($request->input('abilities')){
            $pokemon->abilities = $request->input('abilities');
        }
        if($request->input('egg_groups')){
            $pokemon->egg_groups = $request->input('egg_groups');
        }
        if($request->input('stats')){
            $pokemon->stats = $request->input('stats');
        }
        if($request->input('genus')){
            $pokemon->genus = $request->input('genus');
        }
        if($request->input('description')){
            $pokemon->description = $request->input('description');
        }
        $pokemon->save();
        return "success";
    }

    public function delete(Request $request){
        if($request->input('id')){
            $pokemon = Pokemon::find($request->input('id'));
            if($pokemon){
                $pokemon->delete();
                return "success";
            }
            else{
                return "error";
            }
        }
        else{
            return "error";
        }
    }
}
