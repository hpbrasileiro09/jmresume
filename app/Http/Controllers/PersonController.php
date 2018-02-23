<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;

use LucaDegasperi\OAuth2Server\Facades\Authorizer;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\User;

use Carbon\Carbon;

use Auth;

use Validator;

class PersonController extends Controller
{

    public $path_view = 'person';

    public $header_view = 'Meus Dados';

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = Auth::user();

        return view('admin.' . $this->path_view . '.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $user = Auth::user();

        $published = \Helpers::getPublished();

        return view('admin.' . $this->path_view . '.edit', 
            compact('user','published'));        
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

            $_user = User::findOrFail($id);

            $_user->update([
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

            $_user = User::findOrFail($id);

            $_user->update([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
            ]);

        }

        return response()->redirectToRoute($this->path_view . '.show', $id);
    }

    /*************************************************/

    public function passwordreset(Request $request)
    {
        date_default_timezone_set("America/Sao_Paulo");

        $_resp = "OK";

        $_message = "Senha alterada com sucesso!";

        $senha_usuario = \Helpers::antiSQL($request->input('password'));

        $_user = User::find(Authorizer::getResourceOwnerId());

        $_user->update([
            'reset_pwd' => '0',
            'password' => bcrypt($senha_usuario),
        ]);            

        return [
            'message' => $_resp,
            'content' => $_message,
        ];

    }

}
