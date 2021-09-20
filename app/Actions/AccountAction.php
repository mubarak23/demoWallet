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
            return Account::create($data);
            DB::commit();
        }catch (\Exception $exception) {
             DB::rollback();
            return $exception->getMessage();
        }
    }

}
