<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Post;

use App\Research;

use App\Event;

use App\Associated;

use App\Param;

class AdminController extends Controller
{
    
    public function index() {

        $_credits = $this->_getTotal();
        $_debts = $this->_getTotal(false);

        $credits = number_format($_credits[0]->total, 2, ',', '.');
        $debts = number_format($_debts[0]->total, 2, ',', '.');

        $_param = Param::findOrFail(1);
        $d = new \DateTime( $_param->value );
        $params = $d->format( 'd/m/Y' );

        $_i = 0;
        $ds = DIRECTORY_SEPARATOR;
        $dumpdir = storage_path() . $ds . 'dumps' . $ds;
        $dir = $dumpdir;
        $files1 = scandir($dir);
        foreach($files1 as $k => $v) {
            $_data = explode("_", $v);
            $_timestamp = strtotime($_data[0]); 
            $pos = strpos($v, "Jmresume.sql");
            if (date('Y', $_timestamp) != date('Y')) continue;
            $_i++;
        }
        $backups = $_i;

        //return view('admin_template')->with(\Helpers::_getDataAdminLTE());

        return view('welcome',compact('debts', 'credits', 'params', 'backups'));

    }

    public function _getTotal($_credit = true) {

        $sql = "";
        $sql .= "SELECT ";
        $sql .= "SUM(e.vl_entry) AS total ";
        $sql .= "FROM ";
        $sql .= "entries e ";
        $sql .= "WHERE ";
        $sql .= "e.published = 1 AND ";
        $sql .= "e.status = 1 AND ";
        if ($_credit == true) {
            $sql .= "e.vl_entry >= 0 AND ";
        } else {
            $sql .= "e.vl_entry < 0 AND ";
        }
		$sql .= "YEAR(e.dt_entry) = YEAR(NOW()) and MONTH(e.dt_entry) = MONTH(NOW()) ";

        $regs = DB::select($sql);

        return $regs;

    }

    public function teste() {

        //return Associated::where('published','=','1')->get()->count();

    	$_total = 10;
    	$_yes = 5;

    	$_teste = (100*$_yes)/$_total;

    	$data = Array(
    		'total' => $_total,
    		'yes' => $_yes,
    		'teste' => $_teste,
            'pwd_default' => bcrypt('rosana09'),
            'pwd_numbers' => bcrypt('123456'),
    	);

        return $data;

    }

}
