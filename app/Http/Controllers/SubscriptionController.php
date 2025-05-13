<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Cashier\Exceptions\IncompletePayment;

class SubscriptionController extends Controller
{
    public function subscribe(Request $request)
    {
        $user = Auth::user(); // user login
        $paymentMethod = $request->input('payment_method'); //  'pm_card_visa'
        $planId = 'price_1NMxxxxx'; //  Stripe

        try {
            $user->newSubscription('default', $planId)
                ->create($paymentMethod);

            return redirect()->route('dashboard')->with('success', 'Subscription created successfully!');
        } catch (IncompletePayment $exception) {
            return redirect()->route(
                'cashier.payment',
                [$exception->payment->id, 'redirect' => route('dashboard')]
            );
        }
    }
}
