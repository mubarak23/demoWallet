<?php
namespace App\Actions;
use App\Exceptions\InvalidRequestException;
use App\Account;
use DB;

class AccountAction{

    public function execute(array $data)
    {
        DB::beginTransaction();
        try {
            $create_account =  Account::create($data);
            DB::commit();
            return $create_account;
        }catch (\Exception $exception) {
             DB::rollback();
            return $exception->getMessage();
        }
    }

}
