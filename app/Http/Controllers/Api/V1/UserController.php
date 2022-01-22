<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Api\V1\User\UserRegisterRequest;
use App\Models\User;
use App\Repositories\RoleRepository;

class UserController extends Controller
{
    public $roleRepository;

    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRegisterRequest $request)
    {
        // Если role_id нет возвращаем 400 статус код
        if (empty($this->roleRepository->getRoleById($request->role_id))) {
            return response([
                'messages' => [
                    'role_id' => [
                        'Роли с данным ID нет'
                    ]
                ]
            ], 400);
        }


        // Создаем нового пользователя
        $newUser = new User();
        $newUser->first_name = $request->first_name;
        $newUser->last_name  = $request->last_name;
        $newUser->email      = $request->email;
        $newUser->role_id    = $request->role_id;
        $newUser->password   = bcrypt($request->password);
        $newUser->created_at = now();
        $newUser->save();

        if ($request->hasFile('user_avatar')) {
            $newUser->addMedia($request->file('user_avatar'))
                    ->toMediaCollection('user_avatar');
        }

        return response([
            'status' => true 
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    public function login()
    {

    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
