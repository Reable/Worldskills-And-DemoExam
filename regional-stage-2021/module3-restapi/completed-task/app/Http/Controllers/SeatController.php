<?php

namespace App\Http\Controllers;

use App\Models\BookingsModel;
use App\Models\PassengersModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SeatController extends Controller
{
    public function seat(Request $request){
        $code = $request->route('code');
        $booking_id = BookingsModel::where('code',$code)->select('id')->first()->id;
        $occupied_from = array();
        $occupied_back = array();
        if($storage = PassengersModel::where('booking_id',$booking_id)->whereNotNull('place_from')
            ->select('id','place_from')->get()){
            foreach($storage as $val){
                $occupied_from[] = (object)[
                    'passenger_id'=>$val->id,
                    'place'=>$val->place_from,
                ];
            }
        }else{
            $occupied_from = [];
        }
        if($storage = PassengersModel::where('booking_id',$booking_id)->whereNotNull('place_back')
            ->select('id','place_back')->get()){
            foreach($storage as $val){
                $occupied_back[] = (object)[
                    'passenger_id'=>$val->id,
                    'place'=>$val->place_back,
                ];
            }
        }else{
            $occupied_back= [];
        }
        return response()->json([
            'data'=>(object)[
                'occupied_from'=>$occupied_from,
                'occupied_back'=>$occupied_back,
            ]
        ],200);
    }
    public function seat_update(Request $request){
        $code = $request->route('code');
        $booking_id = BookingsModel::where('code',$code)->select('id')->first()->id;
        $passenger_id = $request->input('passenger');
        $seat = $request->input('seat');
        $type = $request->input('type');
        $validator = Validator::make($request->all(),[
            'passenger'=>'required|numeric',
            'seat'=>'required|regex:/^\d{1,2}\w{1}$/',
            'type'=>'required'
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
        $passenger = PassengersModel::find($passenger_id);
        if($booking_id != $passenger->booking_id){
            return response()->json([
                'error'=>(object)[
                    'code'=>403,
                    'message'=>'Passenger does not apply to booking'
                ]
            ],403);
        }
        if($type == 'from')
            $passenger->place_from = $seat;
        else if($type == 'back')
            $passenger->place_back = $seat;
        $passenger->save();

        return response()->json([
            'data'=>(object)[
                'id'=>$passenger->id,
                'first_name'=>$passenger->first_name,
                'last_name'=>$passenger->last_name,
                'birth_date'=>$passenger->birth_date,
                'document_number'=>$passenger->document_number,
                'place_from'=>$passenger->place_from,
                'place_back'=>$passenger->place_back,
            ]
        ],200);
    }
}
