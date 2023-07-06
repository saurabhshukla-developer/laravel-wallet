<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    /**
     * @method updateWallet
     * Update User Wallet Amount
     * @param $request
     * @return response
     */
    public function updateWallet(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'deposit_amount' => 'required|numeric|decimal:0,2|min:3|max:100',
            ]);

            if ($validator->fails()) {
                return response()->json(['message' => 'Bad or invalid request', 'errors' => $validator->errors()], 400);
            }

            $user = User::find(auth()->user()->id);
            $user->update(['wallet' => $user->wallet + $request->deposit_amount]);

            $data = [
                "message" => "Deposited $".$request->deposit_amount." Successfully, Your wallet balance is $".$user->wallet,
            ];

            return response()->json($data, 200);
        } catch (\Throwable $th) {
            Log::error('An error occurred while updating wallet: ' . $th->getMessage());
            return response()->json(['message' => 'An error occurred while updating wallet'], 500);
        }
    }

    /**
     * @method checkBalance
     * To check the wallet balance of User
     * @param $request
     * @return response
     */
    public function checkBalance(Request $request)
    {
        try {
            $user = User::find(auth()->user()->id);

            $data = [
                "message" => "Your wallet balance is $".$user->wallet,
            ];

            return response()->json($data, 200);
        }catch (\Throwable $th) {
            Log::error('An error occurred while checking wallet balance: ' . $th->getMessage());
            return response()->json(['message' => 'An error occurred while checking wallet balance'], 500);
        }
    }

    
    /**
     * @method buyCookie
     * Buy Cookie for user
     * @param $request
     * @return response
     */
    public function buyCookie(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'quantity' => 'required|numeric|min:1',
            ]);

            if ($validator->fails()) {
                return response()->json(['message' => 'Bad or invalid request', 'errors' => $validator->errors()], 400);
            }

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
            $user->update(['wallet' => $user->wallet - $totalCost]);

            return response()->json(['message' => 'Cookie(s) bought successfully']);
        } catch (\Throwable $th) {
            Log::error('An error occurred while buying cookies: ' . $th->getMessage());
            return response()->json(['message' => 'An error occurred while buying cookies'], 500);
        }
    }


}
