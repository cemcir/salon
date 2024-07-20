<?php

namespace App\Business\Concrete;

use App\Business\Abstract\IUserService;
use App\Core\Utilities\FileOperations\Upload;
use App\Core\Utilities\Results\ErrorResult;
use App\Core\Utilities\Results\IResult;
use App\Core\Utilities\Results\SuccessResult;
use App\DataAccess\Abstract\IUserDal;

class UserManager extends ServiceManager implements IUserService
{
    private IUserDal $userDal;

    public function __construct(IUserDal $userDal)
    {
        $this->userDal=$userDal;
        parent::__construct($userDal,[]);
    }

    public function UserUpdate($user,$image): IResult
    {
        if($image!=null) {
            $result=Upload::ImageUpload($image,'uploads/images/user');
            if(!$result->Status()) {
                return $result;
            }
            $image=$result->Data();
        }

        $user['image']=$image;

        if($this->userDal->Update($user,$user['id'])) {
            return new SuccessResult('');
        }
        return new ErrorResult('');
    }
}
