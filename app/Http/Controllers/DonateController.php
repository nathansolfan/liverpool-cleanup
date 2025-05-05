<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DonateController extends Controller
{
    public function index()
    {
        return view('donate.index');
    }

    public function donate(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:1',
            'frequency' => 'required|in:one-time,monthly',
            'payment_method' => 'required|in:credit_card,paypal',
            'name' => 'required|string|max:255',
            'email' => 'required|email'
        ]);
    }
}
