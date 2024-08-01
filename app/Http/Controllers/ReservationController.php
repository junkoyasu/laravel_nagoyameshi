<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Shop;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reservations = Reservation::where('user_id', Auth::id())->get();
        return view('reservations.index', compact('reservations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Shop $shop)
    {
        return view('reservations.create', compact('shop'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Shop $shop)
    {
        $request->validate([
            'reservation_date' => ['required', 'date_format:Y-m-d'],
            'reservation_time' => ['required', 'date_format:H:i'],
            'number_of_people' => ['required', 'integer', 'min:1', 'max:50'],
        ]);

        $reservation = new Reservation();
        $reservation->reserved_datetime = $request->input('reservation_date') . ' ' . $request->input('reservation_time');
        $reservation->number_of_people = $request->input('number_of_people');
        $reservation->shop_id = $shop->id;
        $reservation->user_id = Auth::user()->id;
        $reservation->save();

        return redirect()->route('shops.reservations.index', $shop)->with('flash_message', '予約が完了しました。');
    }

    
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function destroy(String $id,Reservation $reservation)
    {
        /*dd ($reservation);*/
       if ($reservation->user_id !== Auth::id()) {
            return redirect()->route('reservations.index', $shop)->with('error_message', '不正なアクセスです。');
        } else {
            $reservation->delete();

            return redirect()->route('reservations.index')->with('flash_message', 'キャンセルしました。');
        }
    }
    }

