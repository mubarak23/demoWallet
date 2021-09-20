<?php
namespace App\Actions;
use App\Exceptions\InvalidRequestException;
use App\ClientTransaction;
use DB;

class TransactionAction{

    public function execute(array $data)
    {
        DB::beginTransaction();
        try {
            $create_transaction =  Transaction::create($data);
            DB::commit();
            return $create_transaction;
        }catch (\Exception $exception) {
             DB::rollback();
            return $exception->getMessage();
        }
    }

}
