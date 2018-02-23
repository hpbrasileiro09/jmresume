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

class ReportController extends Controller
{
    
    public $path_view = 'reports';

    public $header_view = 'Reports';

    public function index()
    {
        echo "index";
        exit;
    }

    public function detalhe(Request $request)
    {

        $ano = $request->input('ano', date('Y'));
        $mes = $request->input('mes', 1);

        $entries = Array();
        $debitos = Array();
        $creditos = Array();

        $meses = Array();

        $meses[] = Array( 'id' =>  1, 'abrev' => 'Jan', 'completo' => 'Janeiro' );
        $meses[] = Array( 'id' =>  2, 'abrev' => 'Fev', 'completo' => 'Fevereiro' );
        $meses[] = Array( 'id' =>  3, 'abrev' => 'Mar', 'completo' => 'Marco' );
        $meses[] = Array( 'id' =>  4, 'abrev' => 'Abr', 'completo' => 'Abril' );
        $meses[] = Array( 'id' =>  5, 'abrev' => 'Mai', 'completo' => 'Maio' );
        $meses[] = Array( 'id' =>  6, 'abrev' => 'Jun', 'completo' => 'Junho' );
        $meses[] = Array( 'id' =>  7, 'abrev' => 'Jul', 'completo' => 'Julho' );
        $meses[] = Array( 'id' =>  8, 'abrev' => 'Ago', 'completo' => 'Agosto' );
        $meses[] = Array( 'id' =>  9, 'abrev' => 'Set', 'completo' => 'Setembro' );
        $meses[] = Array( 'id' => 10, 'abrev' => 'Out', 'completo' => 'Outubro' );
        $meses[] = Array( 'id' => 11, 'abrev' => 'Nov', 'completo' => 'Novembro' );
        $meses[] = Array( 'id' => 12, 'abrev' => 'Dez', 'completo' => 'Dezembro' );

        $mesesG = Array();

        $zano = $ano;
        $zmes = $mes;

        for ($x=1; $x<=12;$x++)
        {
            if ($zmes > 12) {
                $zmes = 1;
                $zano++;
            } 
            foreach($meses as $lmes) 
            {
                if ($lmes['id'] == $zmes) 
                {
                    $mesesG[] = Array( 'id' => $lmes['id'], 'ano' => $zano, 'abrev' => $lmes['abrev'], 'completo' => $lmes['completo'] );
                    break;
                }
            }
            $zmes++;
        }

        //======================================

        $categoriesC = Array();

        $query = "";
        $query .= "SELECT ";
        $query .= "   c.id, ";
        $query .= "   c.name, ";
        $query .= "   0 AS vl_prev, ";
        $query .= "   0 AS day_prev, ";
        $query .= "   c.ordem ";
        $query .= "FROM ";
        $query .= "   categories c ";
        $query .= "WHERE ";
        $query .= "   c.id IN ( 81, 82, 87, 116, 120, 126, 127, 128 ) ";
        $query .= "ORDER BY ";
        $query .= "   c.ordem DESC ";

        $registers = DB::select($query);

        $i=0;
        foreach($registers as $linha) 
        { 
            $categoriesC[] = $linha;
            $i++;
        }

        //======================================

        $categoriesD = Array();

        $query = "";
        $query .= "SELECT ";
        $query .= "   c.id, ";
        $query .= "   c.name, ";
        $query .= "   c.vl_prev, ";
        $query .= "   c.day_prev, ";
        $query .= "   c.ordem ";
        $query .= "FROM ";
        $query .= "   categories c ";
        $query .= "ORDER BY ";
        $query .= "   c.ordem DESC ";

        $registers = DB::select($query);

        $i=0;

        $tprev = 0;
        foreach($registers as $linha) 
        { 
            $tprev += $linha->vl_prev;
            $categoriesD[] = $linha;
            $i++;
        }

        //======================================

        $agorax = '2010-01-01 00:00:00';
        $futuro = ($ano + 1) . '-01-01 00:00:00';
        $faixaax= '0';
        $faixabx= '0';

        $query = "";

        $query .= "SELECT ";
        $query .= "   'C' AS tipo, ";
        $query .= "   j.id, ";
        $query .= "   j.id_category, ";
        $query .= "   c.name AS nm_category, ";
        $query .= "   MONTH(j.dt_entry) AS mes, ";
        $query .= "   YEAR(j.dt_entry) AS ano, ";
        $query .= "   j.vl_entry, ";
        $query .= "   j.ds_category, ";
        $query .= "   j.ds_subcategory, ";
        $query .= "   j.status, ";
        $query .= "   j.fixed_costs, ";
        $query .= "   j.checked, ";
        $query .= "   j.published ";
        $query .= "FROM ";
        $query .= "   entries j ";
        $query .= "   INNER JOIN categories c ON c.id = j.id_category ";
        $query .= "WHERE ";
        $query .= "   j.status = 1 AND ";
        $query .= "   j.published = 1 AND ";
        $query .= "   j.vl_entry > 0 AND ";
        $query .= "   j.dt_entry BETWEEN Str_to_date(Date_format(ADDDATE('" . $agorax . "',+" . $faixabx . "),'%Y-%m-%d 00:00:00'),Get_format(DATETIME,'iso')) AND '" . $futuro . "' ";

        $creditos = DB::select($query);

        $query = "";
        $query .= "SELECT ";
        $query .= "   'D' AS tipo, ";
        $query .= "   j.id, ";
        $query .= "   j.id_category, ";
        $query .= "   c.name AS nm_category, ";
        $query .= "   MONTH(j.dt_entry) AS mes, ";
        $query .= "   YEAR(j.dt_entry) AS ano, ";
        $query .= "   j.vl_entry, ";
        $query .= "   j.ds_category, ";
        $query .= "   j.ds_subcategory, ";
        $query .= "   j.status, ";
        $query .= "   j.fixed_costs, ";
        $query .= "   j.checked, ";
        $query .= "   j.published ";
        $query .= "FROM ";
        $query .= "   entries j ";
        $query .= "   INNER JOIN categories c ON c.id = j.id_category ";
        $query .= "WHERE ";
        $query .= "   j.status = 1 AND ";
        $query .= "   j.published = 1 AND ";
        $query .= "   j.vl_entry <= 0 AND ";
        $query .= "   j.dt_entry BETWEEN Str_to_date(Date_format(ADDDATE('" . $agorax . "',+" . $faixabx . "),'%Y-%m-%d 00:00:00'),Get_format(DATETIME,'iso')) AND '" . $futuro . "' ";

        $debitos = DB::select($query);

        return view('admin.' . $this->path_view . '.detalhe', 
            compact(
                'tprev',
                'lmes',
                'ano',
                'mesesG',
                'categoriesC',
                'categoriesD',
                'debitos',
                'creditos'
            ));    

    }

}

