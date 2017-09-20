<?php
namespace Posmat\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use DB;

class APIController extends Controller
{
    public function index()
    {
        return DB::table("countries")->pluck("name","id")->all();
        
    }
    public function getStateList(Request $request)
    {
        $states = DB::table("states")
                    ->where("country_id",$request->country_id)
                    ->pluck("name","id_state");
        return response()->json($states);
    }
    public function getCityList(Request $request)
    {
        $cities = DB::table("cities")
                    ->where("state_id",$request->state_id)
                    ->pluck("name","id");
        return response()->json($cities);
    }
}