<?php

namespace App\Http\Controllers;

use App\Review;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $review_states = [
            "pending" => Review::whereState(0)->count(),
            "finished" => Review::whereState(1)->count()
        ];

        $reviews = Review::orderByDesc('created_at')
                         ->take(10)
                         ->get();

        return view('home', [
            'reviews' => $reviews,
            'review_states' => $review_states
        ]);
    }
}
