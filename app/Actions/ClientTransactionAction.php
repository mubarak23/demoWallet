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
            return Transaction::create($data);
            DB::commit();
        }catch (\Exception $exception) {
             DB::rollback();
            return $exception->getMessage();
        }
    }

}
