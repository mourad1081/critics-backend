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
     * @param string $type_review
     * @return \Illuminate\Http\Response
     */
    public function index(string $type_review)
    {
        $accepted_types = [
            // id of the type of forms
            "restaurant" => 1,
            "hostel" => 2
        ];

        $review_description = [
            // id of the type of forms
            "restaurant" => 'Critique gastronomique',
            "hostel" => 'Hôtel & Resort'
        ];

        if (!key_exists($type_review, $accepted_types)) {
            abort(404);
        }

        $review_states = [
            "pending" => Review::where('state', 0)->where('form_definition_id', $accepted_types[$type_review])->count(),
            "finished" => Review::where('state', 1)->where('form_definition_id', $accepted_types[$type_review])->count()
        ];

        $reviews = Review::where('form_definition_id', $accepted_types[$type_review])
                         ->orderByDesc('created_at')
                         ->take(10)
                         ->get();

        return view('home', [
            'slug' => $type_review,
            'id_type_review' => $accepted_types[$type_review],
            'type_review' => $review_description[$type_review],
            'reviews' => $reviews,
            'review_states' => $review_states
        ]);
    }
}
