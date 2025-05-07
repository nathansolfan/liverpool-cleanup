<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Exception\ApiErrorException;
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

        // Validate form inputs
        $validated = $request->validate([
            'amount' => 'required|numeric|min:1',
            'frequency' => 'required|in:one-time,monthly',
            'payment_method' => 'required|in:credit_card,paypal',
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'payment_method_id' => 'required|string'

        ]);

        // OPTION 2: Get the entire user and check if it exists
        $user = Auth::user();
        $userId = $user ? $user->id : null;

        // Stripe implementation
        try {
            // Set Stripe API Key
            Stripe::setApiKey(config('services.stripe.secret'));

            // create payment intent
            $amount = round($validated['amount'] * 100); // converto to pences

            $paymentIntent = PaymentIntent::create([
                'amount' => $amount,
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
                $donation = Donation::create([
                    'user_id' => auth()->id(),
                    'amount' => $validated['amount'],
                    'frequency' => $validated['frequency'],
                    'payment_method' => $validated['payment_method'],
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'stripe_payment_id' => $paymentIntent->id,
                    'status' => 'completed'
                ]);

                return redirect()->route('donate')->with('success','Thank you for your support');
            } else {
                // Unexpected status
                Donation::create([
                    'user_id' => auth()->id(),
                    'amount' => $validated['amount'],
                    'frequency' => $validated['frequency'],
                    'payment_method' => $validated['payment_method'],
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'stripe_payment_id' => $paymentIntent->id ?? null,
                    'status' => 'failed'
                ]);

                return redirect()->route('donate')->with('error','An expected error');

            }
        } catch (ApiErrorException $e) {
            //Handle Stripe API errors
            //Log failed donation
            Donation::create([
                'user_id' => auth()->id(),
                'amount' => $validated['amount'],
                'frequency' => $validated['frequency'],
                'payment_method' => $validated['payment_method'],
                'name' => $validated['name'],
                'email' => $validated['email'],
                'status' => 'failed'
            ]);

            return redirect()->route('donate')->with('error', 'Payment error: ' . $e->getMessage());

        } catch (\Exception $e) {
            // Handle general errors
            return redirect()->route('donate')->with('error', 'An error occurred: ' . $e->getMessage());

        }


        // For now, let's just return a success response
        // In a real app, you'd save the donation to the database
        // and process the payment through Stripe, PayPal, etc.
        // return redirect()->route('donate')->with('success', 'Thank you for your donation! Your support helps keep our communities clean.');
    }
}
