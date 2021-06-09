<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Auth;

class UserController extends Controller
{
    const EDIT = 'edit';
    const DELETE = 'delete';

    /**
     * Update or delete user, only admin user can delete, show message when user attempt to delete and not is admin
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function action(Request $request): \Illuminate\Http\JsonResponse
    {
        if($request->ajax())
        {
            switch ($request->input('action')) {
                case self::EDIT:
                    $this->updateData($request);
                    break;
                case self::DELETE:
                    $this->deleteData($request);
                    break;
            }

            $return = (!Auth::user()->flag_admin) ? ["message" => __('validation.no_has_permission') ] : $request;
            return response()->json($return);
        }
    }

    /**
     * Update user
     * @param Request $request
     */
    protected function updateData(Request $request)
    {
        $user = User::find($request->input('id'));
        $user->setAttribute('name', $request->input('Name'));
        $user->setAttribute('phone_number', $request->input('Cellphone'));
        $user->setAttribute('date_of_birth', $request->input('Date'));
        $user->save();
    }

    /**
     * Delete user, if the logged in user is not the admin then return false
     * @param Request $request
     * @return bool
     */
    protected function deleteData(Request $request): bool
    {
        if(!Auth::user()->flag_admin){
            return false;
        }
        $user = User::find($request->input('id'));
        $user->delete();
            return false;
    }

}
