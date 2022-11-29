<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReservationController extends Controller
{
    public function index(){
        $reservations =  Reservation::all();
        return $reservations;
    }
    
    public function show($id)
    {
        $reservations = Reservation::find($id);
        return $reservations;
    }
    public function destroy($id)
    {
        Reservation::find($id)->delete();
    }
    public function store(Request $request)
    {
        $reservation = new Reservation();
        $reservation->user_id = $request->user_id;
        $reservation->book_id = $request->book_id;
        $reservation->start = $request->start;
        $reservation->message = $request->message;
        $reservation->save(); 
    }

    public function update(Request $request, $id)
    {
        //a book_id ne változzon! mert akkor már másik példányról van szó
        $reservation = Reservation::find($id);
        $reservation->user_id = $request->user_id;
        $reservation->book_id = $request->book_id;
        $reservation->start = $request->start;
        $reservation->message = $request->message;
        $reservation->status = $request->status;
        $reservation->save();        
    }

    public function reservationPerUser(){
        $user = Auth::user();
        $reservations = DB::table('reservations as r')
        ->where('r.user_id', '=', $user->id)
        ->count();
        return $reservations;
    }


    public function older(){
        $user = Auth::user();
        $reservations = DB::table('reservations as r')
        ->where('r.user_id', $user->id)
        ->count();
        return $reservations;
    }
}
