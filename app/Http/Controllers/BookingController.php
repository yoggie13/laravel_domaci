<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Models\Booking;

class BookingController extends BaseController
{
    public function getLocations(){
        $location = \DB::table('locations')->get();

        if($location != NULL)
            return $this->sendConfirmation($location, "Ovo su sve trenutno aktivne lokacije");

        return $this->sendError("Nije pronađena nijedna lokacija u bazi");

    }

    public function getBookings(Request $request){
        $sum_price = 0;
        $user_id = $request->input('user_id');

        $users = \DB::table('users')->find($user_id);

        if(!$request->has('user_id'))
            return redirect()->route('/');

        if($users == NULL) 
            return $this->sendError("Ne postoji taj korisnik", 404);


        $users_bookings = \DB::table('bookings')
                            ->join('locations','bookings.location_id', '=' ,'locations.id')
                            ->where('user_id', $user_id)
                            ->get();

        foreach($users_bookings as $booking){
            $sum_price += $booking->price;
        }

        if(!$users_bookings->isEmpty())
            return $this->sendConfirmation($users_bookings, "Ukupna cena svih aranžmana je:"." ".$sum_price);

        return $this->sendError("Ovaj korisnik još nije bukirao ništa.");
    
    }
    public function addBooking(Request $request){

        $validated = $request->validate([
            'user_id' => ['required'],
            'location_id' => ['required'],
            'start_date' => ['required'],
            'end_date' => ['required']
        ]);

        $user_booking = \DB::table('bookings')
                            ->where('user_id', $request->input('user_id'))
                            ->where('location_id', $request->input('location_id'))
                            ->where('start_date', date("Y-m-d", strtotime($request->input('start_date'))))
                            ->where('end_date', date("Y-m-d", strtotime($request->input('end_date'))))
                            ->exists();

        if($user_booking)
            return $this->sendError("Već je bukiran taj aranžman", 400);
        
        $booking = new Booking();

        $booking->user_id = $request->input('user_id');
        $booking->location_id = $request->input('location_id');
        $booking->start_date =  $request->input('start_date');
        $booking->end_date =  $request->input('end_date');
        
        $saved = $booking->save();
      
        if($saved)
            return $this->sendConfirmation(true, "Uspešno sačuvano");

        return $this->sendError("Greška pri čuvanju", 501);
    }

    public function deleteBooking(Request $request){

        $validated = $request->validate([
            'user_id' => ['required'],
            'location_id' => ['required'],
            'start_date' => ['required'],
            'end_date' => ['required']
        ]);

        $user_booking = \DB::table('bookings')
                            ->where('user_id', $request->input('user_id'))
                            ->where('location_id', $request->input('location_id'))
                            ->where('start_date', date("Y-m-d", strtotime($request->input('start_date'))))
                            ->where('end_date', date("Y-m-d", strtotime($request->input('end_date'))))
                            ->exists();

        if(!$user_booking)
            return $this->sendError("Ne postoji taj aranžman", 404);

        $deleted = \DB::table('bookings')
                ->where('user_id', '=', $request->input('user_id'))
                ->where('location_id', '=', $request->input('location_id'))
                ->where('start_date', '=', date("Y-m-d", strtotime($request->input('start_date'))))
                ->where('end_date', '=', date("Y-m-d", strtotime($request->input('end_date'))))
                ->delete();
      
        if($deleted)
            return $this->sendConfirmation(true, "Uspešno obrisano");

        return $this->sendError("Greška pri brisanju", 501);
    }
}
