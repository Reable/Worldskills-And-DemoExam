<?php

namespace App\Http\Controllers;

use App\Models\AirportsModel;
use App\Models\FlightsModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class FlightController extends Controller
{
    public function airport(Request $request){
        $query = $request->input('query');
        $airport = DB::table('airports')
            ->where('name','LIKE','%'.$query.'%')
            ->orWhere('iata','LIKE','%'.$query.'%')
            ->select('name','iata')->get();
        return response()->json([
            'data'=>(object)[
                'items'=>$airport
            ]
        ],200);
    }
    public function flight(Request $request){
        $validator = Validator::make($request->all(),[
            'from'=>'required|string',
            'to'=>'required|string',
            'date1'=>'required|date',
            'date2'=>'date',
            'passengers'=>'required|min:1|max:8',
        ]);
        if($validator->fails()){
            return response()->json([
                'error'=>(object)[
                    'code'=>422,
                    'message'=>'Validation error',
                    'errors'=>$validator->errors()
                ]
            ],422);
        }
        $airport_from = AirportsModel::where('iata',$request->input('from'))->first();
        $airport_back = AirportsModel::where('iata',$request->input('to'))->first();
        $flight_from = DB::table('flights')
            ->where([
                ['from_id',$airport_from->id],
                ['to_id',$airport_back->id],
            ])->get();
        $flight_back = DB::table('flights')
            ->where([
                ['from_id',$airport_back->id],
                ['to_id',$airport_from->id],
            ])->get();
        $to = array();
        $back = array();
        foreach($flight_from as $val){
            $to[] = (object)[
                'flight_id'=>$val->id,
                'flight_code'=>$val->flight_code,
                'from'=>(object)[
                    'city'=>$airport_from->city,
                    'airport'=>$airport_from->name,
                    'iata'=>$airport_from->iata,
                    'date'=>$request->input('date1'),
                    'time'=>$val->time_from
                ],
                'to'=>(object)[
                    'city'=>$airport_back->city,
                    'airport'=>$airport_back->name,
                    'iata'=>$airport_back->iata,
                    'date'=>$request->input('date1'),
                    'time'=>$val->time_to
                ],
                'cost'=>$val->cost,
                'availability'=>156
            ];
        }
        if($request->has('date2')){
            foreach($flight_back as $val){
                $back[] = (object)[
                    'flight_id'=>$val->id,
                    'flight_code'=>$val->flight_code,
                    'from'=>(object)[
                        'city'=>$airport_back->city,
                        'airport'=>$airport_back->name,
                        'iata'=>$airport_back->iata,
                        'date'=>$request->input('date2'),
                        'time'=>$val->time_from
                    ],
                    'to'=>(object)[
                        'city'=>$airport_from->city,
                        'airport'=>$airport_from->name,
                        'iata'=>$airport_from->iata,
                        'date'=>$request->input('date2'),
                        'time'=>$val->time_to
                    ],
                    'cost'=>$val->cost,
                    'availability'=>156
                ];
            }
        }
        return response()->json([
            'data'=>(object)[
                'flights_to'=>$to,
                'flights_back'=>$back,
            ]
        ],200);
    }
}
