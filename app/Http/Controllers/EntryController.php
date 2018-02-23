<?php

namespace App\Http\Controllers;

use LucaDegasperi\OAuth2Server\Facades\Authorizer;

use Illuminate\Support\Facades\File;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

use App\Http\Requests;

use Carbon\Carbon;

use App\Entry;

use App\Category;

use App\Param;

use Validator;

class EntryController extends Controller
{

    public $path_view = 'entry';

    public $header_view = 'Entries';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search = \Request::get('search');
        $page_header = $this->header_view;

        $_param = Param::findOrFail(1);

        $agorax = $_param->value;

        $d = new \DateTime( $agorax );
        $d->modify( 'first day of +24 month' );
        $futuro = $d->format( 'Y-m-d' ) . ' 00:00:00';

        $faixaax='0';
        $faixabx='1';

        $query = "";

        $query .= "SELECT ";
        $query .= "   id, ";
        $query .= "   id_category, ";
        $query .= "   nm_category, ";
        $query .= "   dt_entry, ";
        $query .= "   dt_entry_br, "; 
        $query .= "   ano, ";
        $query .= "   mes, ";
        $query .= "   dia, ";
        $query .= "   dia_da_semana, ";
        $query .= "   vl_entry, ";
        $query .= "   ds_category, ";
        $query .= "   ds_subcategory, ";
        $query .= "   ds_detail, ";
        $query .= "   status, ";
        $query .= "   fixed_costs, ";
        $query .= "   checked, ";
        $query .= "   published, ";
        $query .= "   icone, ";
        $query .= "   cartao ";
        $query .= "FROM ";
        $query .= "   ( ";

        $query .= "SELECT ";
        $query .= "   0 AS id, ";
        $query .= "   0 AS id_category, ";
        $query .= "   'ENTRADA MONEY' AS nm_category, ";
        $query .= "   '' AS dt_entry, ";
        $query .= "   '" . date("d/m/Y",strtotime($agorax)) . "' AS dt_entry_br, "; 
        $query .= "    0 AS ano, ";
        $query .= "    0 AS mes, ";
        $query .= "    0 AS dia, ";
        $query .= "    '' AS dia_da_semana, ";
        $query .= "   SUM(j.vl_entry) AS vl_entry, ";
        $query .= "   '' AS ds_category, ";
        $query .= "   '' AS ds_subcategory, ";
        $query .= "   '' AS ds_detail, ";
        $query .= "   1 AS status, ";
        $query .= "   0 AS fixed_costs, ";
        $query .= "   1 AS checked, ";
        $query .= "   1 AS published, ";
        $query .= "   '' AS icone, ";
        $query .= "   '' AS cartao ";
        $query .= "FROM ";
        $query .= "   entries j ";
        $query .= "WHERE ";
        $query .= "  j.status = 1 AND ";
        $query .= "  j.dt_entry >= '2009-12-20 00:00:00' AND ";
        $query .= "  j.dt_entry <= Str_to_date(Date_format(";
        $query .= "  ADDDATE('" . $agorax . "',+" . $faixaax . "),'%Y-%m-%d 23:59:59'),";
        $query .= "  Get_format(DATETIME,'iso')) ";

        $query .= "UNION ";

        $query .= "SELECT ";
        $query .= "   j.id, ";
        $query .= "   j.id_category, ";
        $query .= "   c.name as nm_category, ";
        $query .= "   j.dt_entry, ";
        $query .= "   COALESCE(DATE_FORMAT(j.dt_entry, '%d/%m/%Y'),'') AS dt_entry_br, "; 
        $query .= "   year(j.dt_entry) as ano, ";
        $query .= "   month(j.dt_entry) as mes, ";
        $query .= "   day(j.dt_entry) as dia, ";
        $query .= "   CASE DATE_FORMAT(j.dt_entry,'%w') ";
        $query .= "     WHEN  1 THEN 'Segunda' ";
        $query .= "     WHEN  2 THEN 'Terça' ";
        $query .= "     WHEN  3 THEN 'Quarta' ";
        $query .= "     WHEN  4 THEN 'Quinta' ";
        $query .= "     WHEN  5 THEN 'Sexta' ";
        $query .= "     WHEN  6 THEN 'Sábado' ";
        $query .= "     ELSE 'Domingo' ";
        $query .= "   END AS dia_da_semana, ";
        $query .= "   j.vl_entry, ";
        $query .= "   j.ds_category, ";
        $query .= "   j.ds_subcategory, ";
        $query .= "   j.ds_detail, ";
        $query .= "   j.status, ";
        $query .= "   j.fixed_costs, ";
        $query .= "   j.checked, ";
        $query .= "   j.published, ";
        $query .= "  CASE j.id_category ";
        $query .= "     WHEN  89 THEN '<img ";
        $query .= "  src=\"icones/globo.png\" width=\"16\" height=\"16\" border=\"0\" alt=\"globo\" />' ";
        $query .= "     WHEN  91 THEN '<img ";
        $query .= "  src=\"icones/telefone.png\" width=\"16\" height=\"16\" border=\"0\" alt=\"telefone\" />' ";
        $query .= "     WHEN  90 THEN '<img ";
        $query .= "  src=\"icones/internet.png\" width=\"16\" height=\"16\" border=\"0\" alt=\"internet\" />' ";
        $query .= "     WHEN  99 THEN '<img ";
        $query .= "  src=\"icones/luz.gif\" width=\"16\" height=\"16\" border=\"0\" alt=\"luz\" />' ";
        $query .= "     WHEN 100 THEN '<img ";
        $query .= "  src=\"icones/house.png\" width=\"16\" height=\"16\" border=\"0\" alt=\"condominio\" />' ";
        $query .= "     WHEN 102 THEN '<img ";
        $query .= "  src=\"icones/hospital.png\" width=\"16\" height=\"16\" border=\"0\" alt=\"unimed\" />' ";
        $query .= "     WHEN 132 THEN '<img ";
        $query .= "  src=\"icones/sercomtel.png\" width=\"16\" height=\"16\" border=\"0\" alt=\"sercomtel\" />' ";
        $query .= "     WHEN 133 THEN '<img ";
        $query .= "  src=\"icones/internet.png\" width=\"16\" height=\"16\" border=\"0\" alt=\"internet\" />' ";
        $query .= "     ELSE '' ";
        $query .= "  END AS icone, ";
        $query .= "  CASE j.ds_subcategory ";
        $query .= "     WHEN  'Mastercard' THEN '<img ";
        $query .= "  src=\"icones/master.gif\" width=\"16\" height=\"16\" border=\"0\" alt=\"master\" />' ";
        $query .= "     WHEN  'Visa' THEN '<img ";
        $query .= "  src=\"icones/visa.gif\" width=\"16\" height=\"16\" border=\"0\" alt=\"visa\" />' ";
        $query .= "     WHEN  'Hering' THEN '<img ";
        $query .= "  src=\"icones/hering.jpg\" width=\"16\" height=\"16\" border=\"0\" alt=\"hering\" />' ";
        $query .= "     ELSE '' ";
        $query .= "  END AS cartao ";
        $query .= "FROM ";
        $query .= "   entries j ";
        $query .= "   INNER JOIN categories c ON c.id = j.id_category ";
        $query .= "WHERE ";
        $query .= "   j.dt_entry BETWEEN ";
        $query .= "  Str_to_date(Date_format(ADDDATE('" . $agorax . "',+" . $faixabx . "),'%Y-%m-%d 00:00:00'),";
        $query .= "  Get_format(DATETIME,'iso')) AND '" . $futuro . "' ";

        if (strlen($search)) { 
            $query .= " AND ( ";
            $query .= " j.ds_category LIKE '%" . $search. "%' OR ";
            $query .= " j.ds_subcategory LIKE '%" . $search. "%' OR ";
            $query .= " c.name LIKE '%" . $search. "%' ";
            $query .= " ) ";
        }

        $query .= ") AS entries ";
        $query.="ORDER BY dt_entry, ds_subcategory";

        $registers = DB::select($query);

        $alert = \Helpers::MontaAlert();

        return view('admin.' . $this->path_view . '.index', 
            compact(
                'query',
                'registers',
                'page_header',
                'search',
                'alert'
            ));    

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_header = $this->header_view;

        $register = new Entry();

        $_category = new Category();
        $categories = $_category->all();

        $published = \Helpers::getPublished();

        $register->dt_entry = Carbon::now()->format('d-m-Y');

        $register->status = 1;
        $register->published = 1;

        return view('admin.' . $this->path_view . '.create', 
            compact('register','categories','published','page_header'));  
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
            'ds_category' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return redirect($this->path_view . '/create')
                        ->withErrors($validator)
                        ->withInput();
        }

        $_reg = Entry::create([
            'id_category' => $request->input('id_category'),
            'dt_entry' => \Helpers::inverteData($request->input('dt_entry'),0),
            'vl_entry' => $request->input('vl_entry'),
            'nm_entry' => $request->input('nm_entry'),
            'ds_category' => $request->input('ds_category'),
            'ds_subcategory' => $request->input('ds_subcategory'),
            'status' => ($request->input('status') == null ? '0' : '1'),
            'fixed_costs' => ($request->input('fixed_costs') == null ? '0' : '1'),
            'checked' => ($request->input('checked') == null ? '0' : '1'),
            'published' => ($request->input('published') == null ? '0' : '1'),
            'ds_detail' => $request->input('ds_detail'),
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

        $register = Entry::findOrFail($id);

        $prehtml = "";
        $prehtml .= "#ID: " . $register->id . "<br />";
        $prehtml .= "Date: " . date("d/m/Y",strtotime($register->dt_entry)) . "<br />";
        $prehtml .= "Description: " . $register->ds_category . (strlen($register->ds_subcategory) > 0 ? " (" . $register->ds_subcategory . ")" : "") . "<br />";
        $prehtml .= "Value: " . $register->vl_entry . "<br />";
        $prehtml .= "Category: " . $register->category->name . " (" . $register->id_category . ")" . "<br />";
        $prehtml .= "Status: " . $register->status . "<br />";
        $prehtml .= "Fixed: " . $register->fixed_costs . "<br />";
        $prehtml .= "Checked: " . $register->checked . "<br />";
        $prehtml .= "Published: " . $register->published;

        $alert = \Helpers::MontaAlert("8");

        return view('admin.' . $this->path_view . '.show', compact('register','page_header','prehtml','alert'));
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

        $register = Entry::findOrFail($id);

        $_category = new Category();
        $categories = $_category->all();

        $published = \Helpers::getPublished();

        $register->dt_entry = \Helpers::mysqlToDate($register->dt_entry);

        return view('admin.' . $this->path_view . '.edit', 
            compact('register', 'categories', 'published', 'page_header'));        
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
            'ds_category' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return redirect($this->path_view . '/' . $id . '/edit')
                        ->withErrors($validator)
                        ->withInput();
        }

        $register = Entry::findOrFail($id);

        $register->id_category = $request->input('id_category');
        $register->dt_entry = \Helpers::inverteData($request->input('dt_entry'),0);
        $register->vl_entry = $request->input('vl_entry');
        $register->nm_entry = $request->input('nm_entry');
        $register->ds_category = $request->input('ds_category');
        $register->ds_subcategory = $request->input('ds_subcategory');
        $register->status = ($request->input('status') == null ? '0' : '1');
        $register->fixed_costs = ($request->input('fixed_costs') == null ? '0' : '1');
        $register->checked = ($request->input('checked') == null ? '0' : '1');
        $register->published = ($request->input('published') == null ? '0' : '1');

        $register->ds_detail = $request->input('ds_detail');

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
        $register = Entry::findOrFail($id);
        $register->delete();

        $kind = 1;
        $msg = 'register was deleted successfully';

        session(['kind' => $kind]);
        session(['msg' => $msg]);

        return response()->redirectToRoute($this->path_view . '.index');        
    }

    public function times()
    {
        $page_header = $this->header_view;

        return view('admin.' . 'times' . '.index', compact('page_header'));        
    }

}
