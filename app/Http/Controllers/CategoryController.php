<?php

namespace App\Http\Controllers;

use LucaDegasperi\OAuth2Server\Facades\Authorizer;

use Illuminate\Support\Facades\File;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Category;

use Validator;

class CategoryController extends Controller
{

    public $path_view = 'category';

    public $header_view = 'Categories';

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
        $registers = $_regs->where('name','LIKE','%'.$search.'%')
            ->select(['categories.*'])
            ->orderBy('name','ASC')
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

        $register = new Category();

        $register->published = 1;

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
            'name' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return redirect($this->path_view . '/create')
                        ->withErrors($validator)
                        ->withInput();
        }

        $_reg = Category::create([
            'name' => $request->input('name'),
            'published' => ($request->input('published') == null ? '0' : '1'),
            'vl_prev' => $request->input('vl_prev'),
            'day_prev' => $request->input('day_prev'),
            'ordem' => $request->input('ordem'),
            'type' => $request->input('type'),
        ]);

        $kind = 1;
        $msg = 'register was created successfully';

        session(['kind' => $kind]);
        session(['msg' => $msg]);

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

        $register = Category::findOrFail($id);

        $prehtml = "";
        $prehtml .= "#ID: " . $register->id . "<br />";
        $prehtml .= "Name: " . $register->name . "<br />";
        $prehtml .= "Type: " . $register->type . "<br />";
        $prehtml .= "Order: " . $register->ordem . "<br />";
        $prehtml .= "Value: " . $register->vl_prev . "<br />";
        $prehtml .= "Day: " . $register->day_prev . "<br />";
        $prehtml .= "Published: " . $register->published;

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

        $register = Category::findOrFail($id);

        $published = \Helpers::getPublished();

        return view('admin.' . $this->path_view . '.edit', 
            compact('register', 'published', 'page_header'));        
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
            'name' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return redirect($this->path_view . '/' . $id . '/edit')
                        ->withErrors($validator)
                        ->withInput();
        }

        $register = Category::findOrFail($id);

        $register->name = $request->input('name');
        $register->published = ($request->input('published') == null ? '0' : '1');
        $register->vl_prev = $request->input('vl_prev');
        $register->day_prev = $request->input('day_prev');
        $register->ordem  = $request->input('ordem');
        $register->type = $request->input('type');

        $register->save();

        $kind = 1;
        $msg = 'register was updated successfully';

        session(['kind' => $kind]);
        session(['msg' => $msg]);

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
        $register = Category::findOrFail($id);
        $register->delete();

        $kind = 1;
        $msg = 'register was deleted successfully';

        session(['kind' => $kind]);
        session(['msg' => $msg]);

        return response()->redirectToRoute($this->path_view . '.index');        
    }

}
