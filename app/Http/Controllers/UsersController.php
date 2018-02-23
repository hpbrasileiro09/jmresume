<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\User;

use Validator;

class UsersController extends Controller
{

    public $path_view = 'users';

    public $header_view = 'Usuários';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page_header = $this->header_view;

        $registers = User::where('role','=','admin')->paginate(20);
        return view('admin.' . $this->path_view . '.index', compact('registers', 'page_header'));        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_header = $this->header_view;

        $register = new User();

        $published = \Helpers::getPublished();

        $register->published = 1;

        return view('admin.' . $this->path_view . '.create', 
            compact('register','published','page_header')); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect($this->path_view . '/create')
                        ->withErrors($validator)
                        ->withInput();
        }

        User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ]);
        return response()->redirectToRoute($this->path_view . '.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $page_header = $this->header_view;

        $register = User::findOrFail($id);
        return view('admin.' . $this->path_view . '.show', compact('register','page_header'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page_header = $this->header_view;

        $register = User::findOrFail($id);

        $published = \Helpers::getPublished();

        $register->published = 1;

        return view('admin.' . $this->path_view . '.edit', 
            compact('register','published','page_header')); 
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

        if (strlen($request->input('password'))) {

            $validator = Validator::make($request->all(), [
                'name' => 'required|max:255',
                'email' => 'required|email|max:255',
                'password' => 'required|min:6|confirmed',
            ]);

            if ($validator->fails()) {
                return redirect($this->path_view . '/' . $id . '/edit')
                            ->withErrors($validator)
                            ->withInput();
            }

            $register = User::findOrFail($id);

            $register->update([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => bcrypt($request->input('password')),
            ]);

        } else {

            $validator = Validator::make($request->all(), [
                'name' => 'required|max:255',
                'email' => 'required|email|max:255',
            ]);

            if ($validator->fails()) {
                return redirect($this->path_view . '/' . $id . '/edit')
                            ->withErrors($validator)
                            ->withInput();
            }

            $register = User::findOrFail($id);

            $register->update([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
            ]);

        }

        return response()->redirectToRoute($this->path_view . '.show', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $register = User::findOrFail($id);
        if ($register->role == 'admin') {
            $register->delete();
        }
        return response()->redirectToRoute($this->path_view . '.index');
    }

}
