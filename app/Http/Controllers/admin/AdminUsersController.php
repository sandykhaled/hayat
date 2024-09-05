<?php

namespace App\Http\Controllers\admin;

use Response;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Users\EditUser;
use App\Http\Requests\Users\CreateUser;

class AdminUsersController extends Controller
{
    //
    public function index()
    {
        $users = User::orderBy('id','desc');
        if (isset($_GET['role'])) {
            if ($_GET['role'] != '') {
                $users = $users->where('role',$_GET['role']);
            }
        }
        $users = $users->paginate(25);
        return view('AdminPanel.admins.index',[
            'active' => 'adminUsers',
            'title' => trans('common.users'),
            'users' => $users,
            'breadcrumbs' => [
                [
                    'url' => '',
                    'text' => trans('common.users')
                ]
            ]
        ]);
    }

    public function blockAction($id,$action)
    {
        $update = User::find($id)->update([
            'status' => $action == '1' ? 'Archive' : 'Active'
        ]);
        if ($update) {
            return redirect()->back()
                            ->with('success',trans('common.successMessageText'));
        } else {
            return redirect()->back()
                            ->with('faild',trans('common.faildMessageText'));
        }
    }

    public function create()
    {
        return view('AdminPanel.admins.create',[
            'active' => 'adminUsers',
            'title' => trans('common.users'),
            'breadcrumbs' => [
                                [
                                    'url' => route('admin.adminUsers'),
                                    'text' => trans('common.users')
                                ],
                                [
                                    'url' => '',
                                    'text' => trans('common.CreateNew')
                                ]
                            ]
        ]);
    }

    public function store(CreateUser $request)
    {
        $data = $request->except(['_token','password','hidden','attachments','profile_photo','identity']);
        if ($request['password'] != '') {
            $data['password'] = bcrypt($request['password']);
        }
        $data['status'] = 'Active';

        $user = User::create($data);
        if ($request->profile_photo != '') {
            $user['profile_photo'] = upload_image_without_resize('users/'.$user->id , $request->profile_photo );
            $user->update();
        }
        if ($request->identity != '') {
            $user['identity'] = upload_image_without_resize('users/'.$user->id , $request->identity );
            $user->update();
        }
        if ($request->attachments != '') {
            $Files = [];
            if ($request->hasFile('attachments')) {
                foreach ($request->attachments as $file) {
                    $Files[] = upload_image_without_resize('users/'.$user->id , $file );
                }
                $user['files'] = base64_encode(serialize($Files));
                $user->update();
            }
        }
        if ($user) {
            return redirect()->route('admin.adminUsers')
                            ->with('success',trans('common.successMessageText'));
        } else {
            return redirect()->back()
                            ->with('faild',trans('common.faildMessageText'));
        }

    }

    public function edit($id)
    {
        $user = User::find($id);
        return view('AdminPanel.admins.edit',[
            'active' => 'adminUsers',
            'title' => trans('common.users'),
            'user' => $user,
            'breadcrumbs' => [
                                [
                                    'url' => route('admin.adminUsers'),
                                    'text' => trans('common.users')
                                ],
                                [
                                    'url' => '',
                                    'text' => trans('common.edit').': '.$user->name
                                ]
                            ]
        ]);
    }

    public function update(EditUser $userRequest, $id)
    {
        $user = User::find($id);
        $data = $userRequest->except(['_token','password','hidden','attachments','profile_photo','identity']);
        // return $data;
        if ($userRequest->photo != '') {
            if ($user->photo != '') {
                delete_image('users/'.$id , $user->photo);
            }
            $data['photo'] = upload_image_without_resize('users/'.$id , $userRequest->photo );
        }
        if ($userRequest['password'] != '') {
            $data['password'] = bcrypt($userRequest['password']);
        }
        if ($userRequest->attachments != '') {
            if ($user->files != '') {
                $Files = unserialize(base64_decode($user->files));
            } else {
                $Files = [];
            }
            if ($userRequest->hasFile('attachments')) {
                foreach ($userRequest->attachments as $file) {
                    $Files[] = upload_image_without_resize('users/'.$id , $file );
                }
                $data['files'] = base64_encode(serialize($Files));
            }
        }

        $update = User::find($id)->update($data);
        if ($update) {
            return redirect()->route('admin.adminUsers')
                            ->with('success',trans('common.successMessageText'));
        } else {
            return redirect()->back()
                            ->with('faild',trans('common.faildMessageText'));
        }

    }

    public function DeleteuserPhoto($id,$photo,$X)
    {
        if (!userCan('users_delete_photo')) {
            return Response::json("false");
        }
        $user = User::find($id);
        $Files = [];
        if ($user->files != '') {
            $Files = unserialize(base64_decode($user->files));
        }
        if (in_array($photo,$Files)) {
            delete_image('uploads/users/'.$id , $photo);
            if (($key = array_search($photo, $Files)) !== false) {
                unset($Files[$key]);
            }
            $user['files'] = base64_encode(serialize($Files));
            $user->update();
            return Response::json('photo_'.$X);
        }
        return Response::json("false");
    }

    public function delete($id)
    {
        $user = User::find($id);
        if ($user->delete()) {
            return Response::json($id);
        }
        return Response::json("false");
    }


}