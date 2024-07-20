<?php

namespace App\DataAccess\Concrete\Eloquent;

use App\Core\DataAccess\Eloquent\EloquentRepositoryBase;
use App\DataAccess\Abstract\IUserDal;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class ElUserDal extends EloquentRepositoryBase implements IUserDal
{
    public function __construct(User $user)
    {
        parent::__construct($user);
    }

}
