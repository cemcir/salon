<?php

namespace App\Http\Controllers\Api\Backend;

use App\Business\Abstract\IUserService;
use App\Business\Validation\Keys;
use App\Core\Utilities\FileOperations\Upload;
use App\Http\Controllers\Controller;
use http\Env\Response;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private IUserService $userService;

    public function __construct(IUserService $userService)
    {
        $this->userService=$userService;
        parent::__construct($userService,[],[]);
    }

    public function UserUpdate(Request $request)
    {
        $image=null;
        if($request->has('image')) {
            $image=$request->file('image');
        }

        $user=$request->only(Keys::UserForUpdate());

        $result=$this->userService->UserUpdate($user,$image);
        if($result->Status()) {
            return response()->json(['status'=>200,'msg'=>$result->Message()],200);
        }

        return response()->json(['status'=>400,'msg'=>$result->Message()],400);
    }


}
