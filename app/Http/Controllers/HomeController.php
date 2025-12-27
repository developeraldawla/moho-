<?php

namespace App\Http\Controllers;

use App\Models\Tool;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Fetch active tools for the Dynamic Tools Preview section
        $tools = Tool::where('is_active', true)
            ->orderBy('is_premium', 'desc')
            ->take(8)
            ->get();

        return view('front.index', compact('tools'));
    }
}
