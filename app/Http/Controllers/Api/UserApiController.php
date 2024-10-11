<?php

namespace App\Http\Controllers\Api;

/** models */
use App\Models\User;
use App\Models\UserDetail;

/** request */
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;

use Illuminate\Database\QueryException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserApiController extends Controller
{
    public function list()
    {
        try {
            $users = User::with('details')
                           ->paginate(15);

            return $this->jsonRes()
                        ->data($users)
                        ->success();
        } catch (QueryException $qe) {

            return $this->jsonRes()
                        ->message($qe->getMessage())
                        ->error();
        }
    }

    public function view(User $user)
    {
        if ($user)
            $user->details;

        return $this->jsonRes()
                    ->data($user)
                    ->success();
    }

    public function store(UserStoreRequest $request)
    {
        try {
            $createdUser = User::create([
                'username' => $request->username,
                'password' => $request->password,
                'usertype' => $request->usertype
            ]);
       
            $createdUser->details()->create([
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'email' => $request->email
            ]);
    
            return $this->jsonRes()
                        ->message('User Created Successfully.')
                        ->success();
        } catch (QueryException $qe) {

            return $this->jsonRes()
                        ->message($qe->getMessage())
                        ->error();
        }
    }

    public function update(UserUpdateRequest $request, $userId)
    {
        try {
            $userExists = User::find($userId);
            if (!$userExists)
                return $this->jsonRes()->message('User Not Found.')->error();

            $updatedUser = User::where('id', $userId)
                            ->update([
                                'usertype' => $request->usertype
                            ]);
   
            UserDetail::updateOrCreate(
                ['user_id' => $userId],
                [
                    'firstname' => $request->firstname,
                    'lastname' => $request->lastname,
                    'email' => $request->email
                ]
            );

            return $this->jsonRes()
                        ->message('User Updated Successfully.')
                        ->success();
        } catch (QueryException $qe) {

            return $this->jsonRes()
                        ->message($e->getMessage())
                        ->error();
        }
    }

    public function delete($userId)
    {
        try {
            $user = User::find($userId);
            if (!$user)
                return $this->jsonRes()->message('User Not Found.')->error();

            // Soft delete user
            $user->delete();

            // Soft delete user details
            UserDetail::find($userId)->delete();

            return $this->jsonRes()
                        ->message('User Deleted Successfully.')
                        ->success();
        } catch (QueryException $qe) {

            return $this->jsonRes()
                        ->message($e->getMessage())
                        ->error();
        }
    }
}
