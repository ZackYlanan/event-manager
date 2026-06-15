<?php

namespace App\Http\Controllers;

use App\Models\EventCategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{


    public function index()
    {
        $categories = EventCategory::all(); //get all the data in EventCategory model or table
        return response()->json($categories); // returns the data into json
    }
}
