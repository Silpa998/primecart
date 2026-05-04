<?php
    
namespace App\Http\Controllers;
    
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use Illuminate\Support\Arr;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

use Illuminate\Support\Facades\Auth;
    
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request): View
    {
        $data = User::latest()->paginate(5);
  
        return view('users.index',compact('data'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        $roles = Role::pluck('name','name')->all();

        return view('users.create',compact('roles'));
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request): RedirectResponse
    {
    // 1. Validation
    $rules = [
        'name' => 'required',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6|confirmed', // 'confirmed' means there should be a 'password_confirmation' field that matches 'password'
    ];

    if (Auth::check() && Auth::user()->type == 1) {
        $rules['roles'] = 'required';
    }

    $messages = [
        'name.required' => 'Name field is required.',
        'email.required' => 'Email field is required.',
        'email.email' => 'Enter a valid email address.',
        'email.unique' => 'This email is already registered.',
        'password.required' => 'Password is required.',
        'password.min' => 'Password must be at least 6 characters.',
        'password.confirmed' => 'Password confirmation does not match.',
        'roles.required' => 'Please select a role.',
    ];

    $request->validate($rules, $messages);

    // 2. Data Preparation
    $input = $request->all();
    $input['password'] = Hash::make($input['password']);
    
    $selectedRoles = $request->input('roles');

    if ($selectedRoles == 'Admin' || (is_array($selectedRoles) && in_array('Admin', $selectedRoles))) {
        $input['type'] = 1;
    } else {
       $input['type'] = 0;
    }

    // 3. Create User
    $user = User::create($input);

    // UserController.php
    if ($request->has('roles')) {
        $user->assignRole($request->input('roles'));
    } else {
    // Check if the 'User' role exists, otherwise create it
    $role = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'User']);
    $user->assignRole($role);
    }

    // 5. Redirect
    if (Auth::check() && Auth::user()->type == 1) {
        //usercreated by admin, redirect to user list
        return redirect()->route('users.index')->with('success','User created successfully');
    }

    // user from outside (Auth::login - ignore) 
    // redirect to login page with success message
    return redirect()->route('login')->with('success', 'Registration successful! Please login.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id): View
    {
        $user = User::find($id);

        return view('users.show',compact('user'));
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id): View
    {
        $user = User::find($id);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->all();
    
        return view('users.edit',compact('user','roles','userRole'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id): RedirectResponse
    {
        request()->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'same:confirm-password',
            'roles' => 'required'
        ]);
    
        $input = $request->all();

        // --- check if Admin role is selected, if yes set type to 1, else 0 ---
       $selectedRoles = $request->input('roles');

        if ($selectedRoles == 'Admin' || (is_array($selectedRoles) && in_array('Admin', $selectedRoles))) {
           $input['type'] = 1;
        } else {
            $input['type'] = 0;
        }

        //password hashing
        if(!empty($input['password'])){ 
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = Arr::except($input,array('password'));    
        }

        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id',$id)->delete();
    
        $user->assignRole($request->input('roles'));
    
        return redirect()->route('users.index')
                        ->with('success','User updated successfully');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/login');
    }
}