<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFlightRequest;
use App\Http\Resources\FlightResource;
use App\Models\Flight;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FlightController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFlightRequest $request)
    {
        //dd($request['flights']);
//        $rules = [
//            'flights' => 'array',
//            'flights.*.name' => 'required',
//            'flights.*.fromCountry' => 'required',
//            'flights.*.toCountry' => 'required'
//        ];
//        $validatedFlights = $request->validate($rules);
        $flights = array();
        foreach ($request['flights'] as $validatedFlight) {
            //dd($validatedFlight);
            $flight = Flight::create($validatedFlight);
            array_push($flights, $flight);
        }
        return response(FlightResource::collection($flights), Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
