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
            'Authorization' => 'eyJpdiI6IjNCMnNmZHdzWFRNM2lhQWMwOENjYWc9PSIsInZhbHVlIjoiK250R05lUkdPQWt6V3o1VkVJdy94SUxMckE5NGpOWk5xdm5mTm1ZcFpQOD0iLCJtYWMiOiI5YjU3MjM4MDA4ZTViODgyOTEyYWRhZmU1OTFiODc2MmVkMzhkNzMzZDRlMmM1MWZiODZmOGJkNzFhOTY3ZDRmIiwidGFnIjoiIn0=',
        ])->get('https://apiext-dev.id-trec.com/api/v1/principals');

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
