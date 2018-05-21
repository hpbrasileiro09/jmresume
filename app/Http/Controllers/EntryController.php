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

        $query = $this->montaSql($agorax, $search);

        $registers = DB::select($query);

        $alert = \Helpers::MontaAlert();

        $categories = Array();
        $_cat = new Category();
        $_categories = $_cat->select(['categories.*'])->orderBy('name','ASC')->get();

        $i=0;
        foreach($_categories as $linha)
        { 
            $categories[] = Array( 'id' => $linha->id, 'nome' => $linha->name . "&nbsp;(" . $linha->id . ")" );
            $i++;
        }

        $categories     = \Helpers::MontaIdCategory($categories, 0, 200);
        $rb_status      = \Helpers::MontaSimNaoRB("status", "0", "Status");
        $rb_fixed_costs = \Helpers::MontaSimNaoRB("fixed_costs", "0", "Fixo");
        $rb_checked     = \Helpers::MontaSimNaoRB("checked", "0", "Conciliado");
        $rb_published   = \Helpers::MontaSimNaoRB("published", "0", "Publicado");

        return view('admin.' . $this->path_view . '.index', 
            compact(
                'rb_status',
                'rb_fixed_costs',
                'rb_checked',
                'rb_published',
                'categories',
                'query',
                'registers',
                'page_header',
                'search',
                'alert'
            ));    

    }

    public function support()
    {
        $search = \Request::get('search');
        $page_header = $this->header_view;

        $_param = Param::findOrFail(1);
        $agorax = $_param->value;

        $query = $this->montaSql($agorax, $search, false);

        $registers = DB::select($query);

        $alert = \Helpers::MontaAlert();

        $mcategories = Array();
        $_cat = new Category();
        $_categories = $_cat->select(['categories.*'])->orderBy('name','ASC')->get();

        $i=0;
        foreach($_categories as $linha)
        { 
            $mcategories[] = Array( 'id' => $linha->id, 'nome' => $linha->name . "&nbsp;(" . $linha->id . ")" );
            $i++;
        }

        $categories     = \Helpers::MontaIdCategory($mcategories, 0, 200);
        $rb_status      = \Helpers::MontaSimNaoRB("status", "0", "Status");
        $rb_fixed_costs = \Helpers::MontaSimNaoRB("fixed_costs", "0", "Fixo");
        $rb_checked     = \Helpers::MontaSimNaoRB("checked", "0", "Conciliado");
        $rb_published   = \Helpers::MontaSimNaoRB("published", "0", "Publicado");

        return view('admin.' . $this->path_view . '.support', 
            compact(
                'rb_status',
                'rb_fixed_costs',
                'rb_checked',
                'rb_published',
                'categories',
                'mcategories',
                'query',
                'registers',
                'page_header',
                'search',
                'alert'
            ));    

    }

    public function montaSql($agorax, $search, $_union = true)
    {

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

        if ($_union == true)
        {

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
            $query .= "  j.status = 1 ";
            $query .= "  AND j.dt_entry >= '2009-12-20 00:00:00' AND ";
            $query .= "  j.dt_entry <= Str_to_date(Date_format(";
            $query .= "  ADDDATE('" . $agorax . "',+" . $faixaax . "),'%Y-%m-%d 23:59:59'),";
            $query .= "  Get_format(DATETIME,'iso')) ";
            $query .= "UNION ";

        }

        $_images[] = Array( 'id' =>  '89', 'src' => asset('icones/globo.png'),     'alt' => 'globo' );
        $_images[] = Array( 'id' =>  '91', 'src' => asset('icones/telefone.png'),  'alt' => 'telefone' );
        $_images[] = Array( 'id' =>  '90', 'src' => asset('icones/internet.png'),  'alt' => 'internet' );
        $_images[] = Array( 'id' =>  '99', 'src' => asset('icones/luz.gif'),       'alt' => 'luz' );
        $_images[] = Array( 'id' => '100', 'src' => asset('icones/house.png'),     'alt' => 'condominio' );
        $_images[] = Array( 'id' => '102', 'src' => asset('icones/hospital.png'),  'alt' => 'unimed' );
        $_images[] = Array( 'id' => '132', 'src' => asset('icones/sercomtel.png'), 'alt' => 'sercomtel' );
        $_images[] = Array( 'id' => '133', 'src' => asset('icones/internet.png'),  'alt' => 'internet' );

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

        foreach($_images as $item)
        {
            $query .= "     WHEN  ".$item['id']." THEN '<img ";
            $query .= "  src=\"".$item['src']."\" width=\"16\" height=\"16\" border=\"0\" alt=\"".$item['alt']."\" />' ";
        }

        $query .= "     ELSE '' ";
        $query .= "  END AS icone, ";
        $query .= "  CASE j.ds_subcategory ";
        $query .= "     WHEN  'Mastercard' THEN '<img ";
        $query .= "  src=\"".asset("icones/master.gif")."\" width=\"16\" height=\"16\" border=\"0\" alt=\"master\" />' ";
        $query .= "     WHEN  'Visa' THEN '<img ";
        $query .= "  src=\"".asset("icones/visa.gif")."\" width=\"16\" height=\"16\" border=\"0\" alt=\"visa\" />' ";
        $query .= "     WHEN  'Hering' THEN '<img ";
        $query .= "  src=\"".asset("icones/hering.jpg")."\" width=\"16\" height=\"16\" border=\"0\" alt=\"hering\" />' ";
        $query .= "     ELSE '' ";
        $query .= "  END AS cartao ";
        $query .= "FROM ";
        $query .= "   entries j ";
        $query .= "   INNER JOIN categories c ON c.id = j.id_category ";
        $query .= "WHERE ";

        if (strlen($search)) { 
            $query .= " ( ";
            $query .= " j.ds_category LIKE '%" . $search. "%' OR ";
            $query .= " j.ds_subcategory LIKE '%" . $search. "%' OR ";
            $query .= " c.name LIKE '%" . $search. "%' ";
            $query .= " ) ";
        } else {
            $query .= "  j.dt_entry BETWEEN ";
            $query .= "  Str_to_date(Date_format(ADDDATE('" . $agorax . "',+" . $faixabx . "),'%Y-%m-%d 00:00:00'),";
            $query .= "  Get_format(DATETIME,'iso')) AND '" . $futuro . "' ";
        }

        $query .= ") AS entries ";

        if ($_union == true)
        {
            $query.="ORDER BY dt_entry, ds_subcategory ";
        } else {
            $query.="ORDER BY id DESC ";
            $query.="LIMIT 100";
        }

        return $query;

    }

    public function supportsave(Request $request)
    {
        $i = 0;
        $all = $request->all();
        $action = $request->input("action");
        $mat = $request->input("bag");
        $mat0 = explode(",", $mat); 
        foreach($mat0 as $item)
        {
            $ds_category = "";
            $ds_subcategory = "";
            $id_category = "0";
            $vl_entry = "0";
            $dt_entry = "";
            $status = "0";
            $checked = "0";
            $fixed_costs = "0";
            $published = "0";
            foreach ($all as $key => $value) {
                if ($key == $item . "_ds_category")
                    $ds_category = $value;
                if ($key == $item . "_ds_subcategory")
                    $ds_subcategory = $value;
                if ($key == $item . "_id_category")
                    $id_category = $value;
                if ($key == $item . "_vl_entry")
                    $vl_entry = $value;
                if ($key == $item . "_dt_entry")
                    $dt_entry = $value;
                if ($key == $item . "_status")
                    $status = "1";
                if ($key == $item . "_checked")
                    $checked = "1";
                if ($key == $item . "_fixed_costs")
                    $fixed_costs = "1";
                if ($key == $item . "_published")
                    $published = "1";
            }
            $resp[] = Array(
                'id' => $item,
                'ds_category' => $ds_category,
                'ds_subcategory' => $ds_subcategory,
                'id_category' => $id_category,
                'vl_entry' => $vl_entry,
                'dt_entry' => $dt_entry,
                'status' => $status,
                'checked' => $checked,
                'fixed_costs' => $fixed_costs,
                'published' => $published,
            );
            $register = Entry::findOrFail($item);
            if ($action == "1")
            {
                $register->id_category = $id_category;
                $register->dt_entry = $dt_entry;
                $register->vl_entry = $vl_entry;
                $register->ds_category = $ds_category;
                $register->ds_subcategory = $ds_subcategory;
                $register->status = $status;
                $register->fixed_costs = $fixed_costs;
                $register->checked = $checked;
                $register->published = $published;
                $register->save();
            }
            if ($action == "2")
            {
                $register->delete();
            }
            $i++;
        }   

        if ($i > 0)
        {
            $kind = 1;
            $msg = $i . " register(s) were " . ($action == "1" ? "updated" : "deleted") . " successfully";

            session(['kind' => $kind]);
            session(['msg' => $msg . "(" . $action . ")"]);
        }

        return response()->redirectToRoute($this->path_view . '.support');
        return $request->all();
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

        $register->dt_entry = Carbon::now()->format('d/m/Y');

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

        $register->dt_entry = \Helpers::mysqlToDateBr($register->dt_entry);

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

    public function entryjson($id)
    {
        $_entry = new Entry();
        $entries = $_entry->select(['entries.*'])->where('id',$id)->get();
        return $entries;
    }

    public function entrysave(Request $request)
    {

        $register = new Entry();

        if ($request->input('id') == '0') 
        {

            $register = Entry::create([
                'id_category' => $request->input('id_category'),
                'dt_entry' => $request->input('dt_entry'),
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

        } else {

            $register = Entry::findOrFail($request->input('id'));

            $register->id_category = $request->input('id_category');
            $register->dt_entry = $request->input('dt_entry');
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

        }

        return $register;

    }

}
