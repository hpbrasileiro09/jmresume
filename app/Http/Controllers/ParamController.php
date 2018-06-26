<?php

namespace App\Http\Controllers;

use LucaDegasperi\OAuth2Server\Facades\Authorizer;

use Illuminate\Support\Facades\File;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Param;

use Validator;

class ParamController extends Controller
{

    public $path_view = 'param';

    public $header_view = 'Params';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search = \Request::get('search');
        $page_header = $this->header_view;
        $_regs = new Category();
        $registers = $_regs->where('label','LIKE','%'.$search.'%')
            ->select(['params.*'])
            ->orderBy('label','ASC')
            ->paginate(20);
        $alert = \Helpers::MontaAlert();
        return view('admin.' . $this->path_view . '.index', compact('registers','page_header','search','alert'));    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_header = $this->header_view;

        $register = new Param();

        return view('admin.' . $this->path_view . '.create', 
            compact('register', 'page_header'));  
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
            'label' => 'required|max:255',
            'value' => 'required|max:255',
            'default' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return redirect($this->path_view . '/create')
                        ->withErrors($validator)
                        ->withInput();
        }

        $_reg = Param::create([
            'label' => $request->input('name'),
            'value' => $request->input('value'),
            'default' => $request->input('default'),
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

        $register = Param::findOrFail($id);

        $prehtml = "";
        $prehtml .= "#ID: " . $register->id . "<br />";
        $prehtml .= "Label: " . $register->label . "<br />";
        $prehtml .= "Value: " . $register->value . "<br />";
        $prehtml .= "Default: " . $register->default . "<br />";

        $alert = \Helpers::MontaAlert("8");

        return view('admin.' . $this->path_view . '.show', compact('register','page_header', 'prehtml', 'alert'));
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

        $register = Param::findOrFail($id);

        $register->value = \Helpers::mysqlToDateBr($register->value);

        return view('admin.' . $this->path_view . '.edit', 
            compact('register', 'page_header'));        
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
        $validator = Validator::make($request->all(), [
            'label' => 'required|max:255',
            'value' => 'required|max:255',
            'default' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return redirect($this->path_view . '/' . $id . '/edit')
                        ->withErrors($validator)
                        ->withInput();
        }

        $register = Param::findOrFail($id);

        $register->label = $request->input('label');
        $register->value = \Helpers::inverteData($request->input('value'),0);        
        $register->default = $request->input('default');

        $register->save();

        $kind = 1;
        $msg = 'register was updated successfully';

        session(['kind' => $kind]);
        session(['msg' => $msg]);

        return response()->redirectToRoute('entry.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $register = Param::findOrFail($id);
        $register->delete();

        $kind = 1;
        $msg = 'register was deleted successfully';

        session(['kind' => $kind]);
        session(['msg' => $msg]);

        return response()->redirectToRoute($this->path_view . '.index');        
    }

}
