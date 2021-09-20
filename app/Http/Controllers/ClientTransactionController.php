<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;
use App\Actions\ClientTransactionAction;
use App\ClientTransaction;
use App\Account;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClientTransactionController extends Controller
{
    //
     public function process_credit_transaction(Request $request){

        $validation = Validator::make($request->all(), [
            'amount' => 'required',
            'account_no' => 'required',
            'txn_type' => 'required'
        ]);
        if($validation->fails()){
            return response()->json($validation->errors(), 401);
         }
         $data = $request->all();

        $account_exist = Account::where("account_no", $data["account_no"])->exists();
        if(!$account_exist) return response()->json(["message" => "Account Does Not Exists"], 400);

         $account = Account::where("account_no", $data["account_no"])->select('account_balance')->first();

         $data['balance_before'] = $account->balance;
         $data["meta"] = $data["account_no"];

         $credit_account = $this->credit_transaction($data);
         if(!$credit_account){
            return response()->json(["message" => "Credit Transaction was Unsuccessful"], 400);
         }

         $update_account = $this->credit_account($data);

         //send email notifucation
         if($credit_account){
             return response()->json(['message' => 'Account Credited Successfully', 'data' => $credit_account], 201);
         }

    }

    public function credit_transaction($data){
        $credit_data = [
            'txn_type' => 'Credit',
            'amount'  => $data['amount'],
            'account_no' => $data['account_no'],
            'reference' => Str::uuid(),
            'balance_before' => $data['balance_before'],
            'balance_after' => $data['balance_before'] + $data['amount'],
            'metadata' => $data['meta']
        ];
        return $this->add_transaction($credit_data);
    }

    public function add_transaction($data)
    {
        DB::beginTransaction();
        try {
            return ClientTransaction::create($data);
             DB::commit();
        }catch (\Exception $exception) {
            DB::rollback();
            return $exception->getMessage();
        }
    }


    public function credit_account($data){
        DB::beginTransaction();
       try {
        $account = Account::where("account_no", $data["account_no"])->first();
        $account->balance = $account->balance + $data['amount'];
        //return $account->balance;
       $update_account =  $account->save();
       DB::commit();
        return $update_account;
       }catch (\Exception $exception) {
            DB::rollback();
            return $exception->getMessage();

        }

    }

    public function process_debit_transaction(Request $request){
        $validation = Validator::make($request->all(), [
            'amount' => 'required',
            'account_no' => 'required',
            'txn_type' => 'required'
        ]);
        if($validation->fails()){
            return response()->json($validation->errors(), 401);
         }
         $data = $request->all();
        $account_exist = Account::where("account_no", $data["account_no"])->exists();
        return $account_exist;
        if(!$account_exist) return response()->json(["message" => "Account Does Not Exists"], 400);

         $account = Account::where("account_no", $data["account_no"])->select('balance')->first();

         $data['balance_before'] = $account->balance;
         $data["meta"] = $data["account_no"];

         $debit_account = $this->debit_transaction($data);
         if(!$debit_account){
            return response()->json(["message" => "Debit Transaction was Unsuccessful"], 400);
         }

         $update_account = $this->debit_account($data);

         //send email notifucation
         if($credit_account){
             return response()->json(['message' => 'Account Debited was Successfully', 'data' => $credit_account], 201);
         }

    }

     public function debit_account($data){
        DB::beginTransaction();
       try {
        $account = Account::where("account_no", $data["account_no"])->first();
        $account->balance = $account->balance - $data['amount'];
        //return $account->balance;
       $update_account =  $account->save();
       DB::commit();
        return $update_account;
       }catch (\Exception $exception) {
            DB::rollback();
            return $exception->getMessage();

        }

    }

    public function debit_transaction($data){
        $debit_data = [
            'txn_type' => 'Debit',
            'amount'  => $data['amount'],
            'account_no' => $data['account_no'],
            'reference' => Str::uuid(),
            'balance_before' => $data['balance_before'],
            'balance_after' => $data['balance_before'] - $data['amount'],
            'metadata' => $data['meta']
        ];
        return $this->add_debit_transaction($debit_data);
    }

    public function add_debit_transaction($data)
    {
        DB::beginTransaction();
        try {
            return ClientTransaction::create($data);
             DB::commit();
        }catch (\Exception $exception) {
            DB::rollback();
            return $exception->getMessage();
        }
    }


}
