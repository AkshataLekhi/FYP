<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function add(Request $request)
    {
        $stars = $request->input('product_rating');
    }


    public function store(Request $request)
    {
    // handle the form submission
    }

}
