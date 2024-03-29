<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    protected $user;

    /**
     * UsersController constructor.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Display a listing of users.
     *
     * @param Request $request
     * @return view
     */
    public function index(Request $request)
    {
        $input = $request->all();
        $users = $this->user->getUsersFromDB($input);
        return view('users/index', ['users' => $users]);
    }

    /**
     * Show the form for creating a new user.
     *
     * @return view
     */
    public function create()
    {
        return view('users/create');
    }

    /**
     * Store a newly user in storage.
     *
     * @param StoreUserRequest $request
     * @return view
     */
    public function store(StoreUserRequest $request)
    {
        $input = $request->all();
        $this->user->createUser($input);
        flash('Thêm mới người dùng thành công.')->success();
        return redirect()->route('users.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = $this->user->findUser($id);
        return view('users/edit', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreUserRequest $request
     * @return \Illuminate\Http\Response
     */
    public function update(StoreUserRequest $request)
    {
        $input = $request->all();
        if ($this->user->updateUser($input)) {
            flash('Cập nhập người dùng thành công.')->success();
        } else {
            flash('Cập nhập người dùng thất bại.')->error();
        }
        return redirect()->route('users.index');
    }
}
