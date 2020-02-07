<?php

namespace App\Http\Controllers;
use App\User;
use App\UsersGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class UsersController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    { 
        $usersList = User::with('users_group')->get();
        $usersGroup = UsersGroup::all();
        
        return view('pages/users', compact('usersList', 'usersGroup'));
        
    }

   /**
    * Lista todos os usuarios com seu respectivo grupo
    * @return \Illuminate\Http\Response
    */
    public function usersList()
    { 
        $usersList = User::with('users_group')->orderBy('created_at', 'desc')->get();
        return [
            'num_rows'=>User::count(),
            'users'=>$usersList
        ]; 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
        $validator = Validator::make($request->all(),[
            'name'=>['required', 'max:35', 'min:5'],
            'email'=>['required','email','unique:users','max:35', 'min:5'],
            'users_group_id'=> ['required', 'numeric'],
            'password' =>['required', 'min:3']
        ],['email.unique'=>'O email já está em uso']);

        try {
            $user = new User();
            $user->name  = $request->name;
            $user->email = $request->email;
            $user->users_group_id = $request->users_group_id;
            $user->password = Hash::make($request->password);
            $user->save();
        } catch (\Exception $e) {
            return response()->json($validator->errors(), 400);            
        }    
        return $user;
        
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user =  User::find($id);
        return $user;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
        $validator = Validator::make($request->all(),[
            'name' => ['required', 'max:35', 'min:5'],
            'email'=> ['required','email','unique:users,email,'.$id,'max:35', 'min:5'],
            'users_group_id'=> ['required', 'numeric']
        ],
        [
            'email.unique'=>'O email já está em uso'
        ]);
        try {
            $user =  User::find($id);
            $user->name  = $request->name;
            $user->email = $request->email;
            $user->users_group_id = $request->users_group_id;
            $user->save();
        } catch (\Exception $e) {
            return response()->json($validator->errors(), 400);
        }
        return $user;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        \Log::info(auth()->user());
        //$user = User::find($id);
        //Log::info($userName. 'Deletou o usuario(a)'.$user->name);
       // $user->delete();
        
    }
}
