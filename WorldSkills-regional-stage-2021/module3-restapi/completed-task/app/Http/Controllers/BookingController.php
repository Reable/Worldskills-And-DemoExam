<?php

namespace App\Http\Controllers;

use App\Models\AirportsModel;
use App\Models\BookingsModel;
use App\Models\FlightsModel;
use App\Models\PassengersModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    public function booking(Request $request){
        $flight_from = $request->input('flight_from');
        $flight_back = $request->input('flight_back');
        $passengers = $request->input('passengers');
        $errors = array();
        foreach($passengers as $pass){
            $passenger =[
                'first_name'=>$pass['first_name'],
                'last_name'=>$pass['last_name'],
                'birth_date'=>$pass['birth_date'],
                'document_number'=>$pass['document_number'],
            ];
            $validator = Validator::make($passenger,[
                'first_name'=>'required|string',
                'last_name'=>'required|string',
                'birth_date'=>'required|date',
                'document_number'=>'required|string|digits:10',
            ]);
            if($validator->fails()) $errors[] = $validator->fails();
        }
        if($validator->fails()){
            return response()->json([
                'error' => (object)[
                    'code'=>422,
                    'message'=>'Validation error',
                    'errors'=>$errors
                ]
            ],422);
        }
        $code = Str::random(5);
        $booking = new BookingsModel();
        $booking->flight_from = $flight_from['id'];
        $booking->flight_back = $flight_back['id'];
        $booking->date_from = $flight_from['date'];
        $booking->date_back = $flight_from['date'];
        $booking->code = $code;
        $booking->save();
        foreach($passengers as $pass){
            $passenger = new PassengersModel();
            $passenger->booking_id = $booking->id;
            $passenger->first_name = $pass['first_name'];
            $passenger->last_name = $pass['last_name'];
            $passenger->birth_date = $pass['birth_date'];
            $passenger->document_number = $pass['document_number'];
            $passenger->save();
        }
        return response()->json([
            'data'=>(object)[
                'code'=>$code
            ]
        ],201);
    }
    function booking_info(Request $request){
        $code = $request->route('code');
        $booking = BookingsModel::where('code',$code)->first();
        $flights_from = FlightsModel::where('id',$booking->flight_from)->first();
        $flights_back = FlightsModel::where('id',$booking->flight_back)->first();
        $airport_from = AirportsModel::where('id',$flights_from->from_id)->first();
        $airport_back = AirportsModel::where('id',$flights_from->to_id)->first();
        $passengers = PassengersModel::where('booking_id',$booking->id)
            ->select('id','first_name','last_name','birth_date','document_number','place_from')
            ->get();
        $allcost = ($flights_from->cost + $flights_back->cost) * count($passengers);

        $response = (object)[
            'data'=>(object)[
                'code'=>$code,
                'cost'=>$allcost,
                'flights'=>[
                    (object)[
                        'flight_id'=>$flights_from->id,
                        'flight_code'=>$flights_from->flight_code,
                        'from'=>(object)[
                            'city'=>$airport_from->city,
                            'airport'=>$airport_from->name,
                            'iata'=>$airport_from->iata,
                            'date'=>$booking->date_from,
                            'time'=>$flights_from->time_from
                        ],
                        'to'=>(object)[
                            'city'=>$airport_back->city,
                            'airport'=>$airport_back->name,
                            'iata'=>$airport_back->iata,
                            'date'=>$booking->date_back,
                            'time'=>$flights_from->time_to
                        ],
                        'cost'=>$flights_from->cost,
                        'availability'=>56
                    ],
                    (object)[
                        'flight_id'=>$flights_back->id,
                        'flight_code'=>$flights_back->flight_code,
                        'from'=>(object)[
                            'city'=>$airport_back->city,
                            'airport'=>$airport_back->name,
                            'iata'=>$airport_back->iata,
                            'date'=>$booking->date_from,
                            'time'=>$flights_back->time_from
                        ],
                        'to'=>(object)[
                            'city'=>$airport_from->city,
                            'airport'=>$airport_from->name,
                            'iata'=>$airport_from->iata,
                            'date'=>$booking->date_back,
                            'time'=>$flights_back->time_to
                        ],
                        'cost'=>$flights_back->cost,
                        'availability'=>56
                    ],
                ],
                'passengers'=>$passengers
            ]
        ];
        return response()->json($response,200);
    }
}
