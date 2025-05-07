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
            'email' => 'required|email',
            'payment_method_id' => 'required|string'

        ]);

        // Stripe implementation
        try {
            // Set Stripe API Key
            Stripe::setApiKey(config('services.stripe.secret'));

            // create payment intent
            $amount = round($validated['amount'] * 100); // converto to pences

            $paymentIntent = PaymentIntent::create([
                'amount' => '$amount',
                'currency' => 'gbp',
                'payment_method' => $validated['payment_method_id'],
                'confirmation_method' => 'manual',
                'confirm' => true,
                'description' => 'Community Cleanup Donation',
                'receipt_email' => $validated['email'],
                'metadata' => [
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'frequency' => $validated['frequency']
                ]
            ]);


            // Handle next action if needed
            if ($paymentIntent->status === 'required_action' && $paymentIntent->next_action->type === 'user_stripe_sdk') {
                //return the client secret and required addition action
                return response()->json([
                    'requires_action' => true,
                    'payment_intent_client_secret' => $paymentIntent->client_secret
                ]);
            } else if ($paymentIntent->status === 'succeeded') {
                //Payment succeeded
                //TODO: record the donation in the database
                $donation =
            }
        } catch (\Throwable $th) {
            //throw $th;
        }


        // For now, let's just return a success response
        // In a real app, you'd save the donation to the database
        // and process the payment through Stripe, PayPal, etc.
        return redirect()->route('donate')->with('success', 'Thank you for your donation! Your support helps keep our communities clean.');
    }
}
