<?php

namespace App\Core\Validation;

use App\Core\Utilities\Results\ErrorResult;
use Illuminate\Http\Request;
use Validator;

class Validate
{
    public static function ValidationMake(Request $request,array $rules)
    {
        $message=null;

        $validator=Validator::make($request->all(),$rules);
        if($validator->fails()) {
            $data=json_decode($validator->errors(),true);
            if(isset($data[0][0])) {
                //$message=array_values(json_decode($validator->errors(),true))[0][0];
                $message=array_values($data[0][0]);
            }
            //if(isset(array_values(json_decode($validator->errors(),true))[0][0])) {

            //}
            return new ErrorResult($message);
        }
        return null;
    }

}
