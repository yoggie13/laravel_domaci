<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;

class BookingController extends BaseController
{
    public function getLocations(){
        $location = \DB::table('locations')->get();

        if($location != NULL)
            return $this->sendConfirmation($location, "Ovo su sve trenutno aktivne lokacije");

        return $this->sendError("Nije pronađena nijedna lokacija u bazi");

    }

    // public function addLocation($name, $picture_url, $description, $price){

    //     \DB::table('locations')->insert
    // }
    public function getBookings(Request $request){
        $sum_price = 0;
        $user_id = $request->input('user_id');
        //$user_id = 1;

        $users = \DB::table('users')->find($user_id);

        if($users == NULL) 
            return $this->sendError("Ne postoji taj korisnik");


        $users_bookings = \DB::table('bookings')
                            ->join('locations','bookings.location_id', '=' ,'locations.id')
                            ->where('user_id', $user_id)
                            ->get();

        foreach($users_bookings as $booking){
            $sum_price += $booking->$price;
        }

        if(!$users_bookings->isEmpty())
            return $this->sendConfirmation($users_bookings, "Ukupna cena svih aranžmana je:"." ".$sum_price);

        return $this->sendError("Ovaj korisnik još nije bukirao ništa.");
    
    }
    public function addBooking(Request $request){
        \DB::table('bookings')->insert([
            'user_id' -> $request->input('user_id'),
            'location_id' -> $request->input('location_id'),
            'start_date' -> $request->input('start_date'),
            'end_date' -> $request->input('end_date')
        ]);

        $output = \DB::table('bookings')
                    ->where('user_id', '=', $request->input('user_id'))
                    ->where('location_id','=', $request->input('location_id'))
                    ->where('start_date','=', $request->input('start_date'))
                    ->where('end_date','=', $request->input('end_date'))
                    ->get();

        if(!isEmpty($output))
            return $this->sendConfirmation($output, "Sledeći aranžman uspešno sačuvan");

        return $this->sendError("Nije moguće sačuvati", 300);
    }

}
