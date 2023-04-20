<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $complaints = Complaint::latest()->take(6)->get();
        return view('pages.home.index', compact('complaints'));
    }
    public function getData(Request $request)
    {
        $response = Http::withHeaders([
            'Authorization' => 'eyJpdiI6Ikc0RHdiOUF0TU9IQWpoVVR3SVFNU0E9PSIsInZhbHVlIjoiN2pEd3ZObmZTYStYdVhzL1NFUGlldz09IiwibWFjIjoiMTVkMGQyYTQxYWRmM2IzZWY4OWVmZTUyOGUwNGFmY2E1MzAwZTBlYTIwNjI5ODRkODVhYTQyZjIyYTgwMWJkZSIsInRhZyI6IiJ9YspAJbi4jljFFRy',
        ])->get('https://apiext-dev.id-trec.com//api/v1/principals');

        if ($response->successful()) {
            return response()->json([
                'status' => true,
                'data' => $response->json()
            ], 200);
        } else {
            $errorCode = $response->status();
            $errorMessage = $response->json()['message'];
            return response()->json([
                'status' => false,
                'error' => $errorMessage,
            ], $errorCode);
        }
    }
}
