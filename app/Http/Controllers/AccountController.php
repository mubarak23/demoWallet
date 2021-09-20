<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Account;
use App\Actions\AccountAction;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    //

      public function create_account(Request $request, AccountAction $AccountAction ){

        $validation = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'account_type' => 'required',
            'branch' => 'required'
        ]);
        if($validation->fails()){
            return response()->json($validation->errors(), 401);
         }
         $data = $request->all();
         #check if user exist
         $account_exists = Account::where('first_name', $data["first_name"])->where('last_name', $data["last_name"])->exists();
         if($account_exists) return response()->json(["message" => "Account Already exists"], 400);
         $data["_account_balance"] = "0.00";
         $data["account_no"] = rand(1111111111,9999999999);
         $new_account = $AccountAction->execute($data);

         if($new_account){
             return response()->json(['message' => 'Client Account Created Successfully', 'data' => $new_account], 201);
         }
         return response()->json(['message' => 'Account Creation Failed, Try Again'], 400);

    }
}
