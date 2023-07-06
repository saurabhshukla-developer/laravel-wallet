<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function updateWallet(Request $request){
        $request->validate([
            'deposit_amount' => 'required|numeric|decimal:0,2|min:3|max:100',
        ]);

        $user = User::find(auth()->user()->id);
        $oldAmount = $user->wallet;
        $user->update(['wallet' => $oldAmount + $request->deposit_amount]);

        $data = [
            "message" => "Deposited $".$request->deposit_amount." Successfully, Your wallet balance is $".$user->wallet,
        ];

        return response()->json($data, 200);
    }

    public function buyCookie(Request $request)
    {
        $request->validate([
            'quantity' => 'required|numeric|min:1',
        ]);

        $user = User::find(auth()->user()->id);
        // Calculate the total cost based on the number of cookies to buy
        $numberOfCookies = $request->quantity;
        $cookieCost = 1;
        $totalCost = $numberOfCookies * $cookieCost;

        // Check if the user has enough funds in the wallet
        if ($user->wallet < $totalCost) {
            return response()->json(['message' => 'Insufficient funds'], 403);
        }

        // Update the user's wallet balance
        $user->wallet -= $totalCost;
        $user->save();

        return response()->json(['message' => 'Cookie(s) bought successfully']);
    }


}
