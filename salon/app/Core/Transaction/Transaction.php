<?php

namespace App\Core\Transaction;

use Illuminate\Support\Facades\DB;

class Transaction
{
    public static function TransactionMake(array $function):bool
    {
        try {
            DB::beginTransaction();
            foreach ($function as $item) {
                $item;
            }
            DB::commit();
            return true;
        }
        catch (\Exception $ex) {
            DB::rollBack();
            return false;
        }
    }
}
