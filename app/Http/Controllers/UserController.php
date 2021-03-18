<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        //
    }


    //read all users from db and store them to an array
    public function getUsers()
    {
        $users = [];
        foreach (User::all() as $user) {
            $users[] = [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->admin == 1 ? 'admin' : ($user->manager == 1 ? 'manager' : 'user')
            ];
        }
        return $users;
    }


    //list users
    public function index(Request $request)
    {
        $users = $this->getUsers();
        return view('users')->with('users', $users);
    }


    //show specific user
    public function show(Request $request,$id)
    {
        $user = User::find($id);
        if($user){
            $userData = [];
                $userData[] = [
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->admin == 1 ? 'admin' : ($user->manager == 1 ? 'manager' : 'user')
                ];
                return response($userData);
        }
        else {
            return response("User does not exist!");
        }
    }

    //store new user to database
    public function store(Request $request)
    {
        $user  = new User();
        $user->name = request('name');
        $user->email = request('email');
        $user->password = Hash::make(request('password'));
        $user->admin = request('role') == 'admin' ? 1 : 0;
        $user->manager = request('role') == 'manager' ? 1 : 0;
        $user->save();
        $users = $this->getUsers();
        return response($users);

    }


    //delete user
    public function destroy($id)
    {
        $user = User::find($id);
        if($user)
        {
            $user->delete();
            return response($this->getUsers());
        }
        else
        {
            return redirect('/users')->with('error','User does not exist!');
        }

    }

    //update user
    public function update(Request $request,$id)
    {
        $user = User::find($id);
        if($user)
        {
            $user->name = request('name');
            $user->email = request('email');
            $user->admin = request('role') == 'admin' ? 1 : 0;
            $user->manager = request('role') == 'manager' ? 1 : 0;
            $user->save();
            $users = $this->getUsers();
            return response($users);
        }
        else
        {
            return response("User does not exist!");
        }
    }

}
