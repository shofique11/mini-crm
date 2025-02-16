<?php

namespace App\Http\Controllers;

use App\Http\Controllers\API\BaseController;
use Illuminate\Http\Request;
use App\Models\User;
class UserController extends BaseController
{
    public function counselorList(){
        $success['userlist'] = User::where('role','counselor')->get();
        return $this->sendResponse($success, 'User get successfully.', 200);
    }
}
