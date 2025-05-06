<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class DonateController extends Controller
{
    public function index()
    {
        return view('donate.index');
    }

    public function process(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:1',
            'frequency' => 'required|in:one-time,monthly',
            'payment_method' => 'required|in:credit_card,paypal',
            'name' => 'required|string|max:255',
            'email' => 'required|email'
        ]);

        // Stripe implementation
        if ($validated['payment_method'] === 'credit_card') {
            Stripe::setApiKey(config('services.stripe.secret'));

            // Create payment intent
            $paymentIntent = PaymentIntent::create([
                'amount' => $request->amount * 100, //Convert to pence
                'currency' => 'gbp',
                'description' => 'Community Cleanup Donation',
            ]);
        }

        // For now, let's just return a success response
        // In a real app, you'd save the donation to the database
        // and process the payment through Stripe, PayPal, etc.
        return redirect()->route('donate')->with('success', 'Thank you for your donation! Your support helps keep our communities clean.');
    }
}
