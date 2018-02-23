<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Post;

use App\Research;

use App\Event;

use App\Associated;

class AdminController extends Controller
{
    
    public function index() {

        $notifications = Array();

        $news = Array();

        $researches = Array();

        $events = Array();

        $associateds = 0;

        $posts = 0;

        $tasks = Array();

        //return view('admin_template')->with(\Helpers::_getDataAdminLTE());

        return view('welcome',compact('posts','associateds','notifications','news','researches','events','tasks'));

    }

    public function _getResearches() {

        $sql = "";
        $sql .= "SELECT ";
        $sql .= "r.id, ";
        $sql .= "r.title, ";
        $sql .= "q.name, ";
        $sql .= "'danger' as color, ";
        $sql .= "count(*) as quantity ";
        $sql .= "FROM ";
        $sql .= "research_answers ra ";
        $sql .= "LEFT JOIN researches r ON ra.research_id = r.id ";
        $sql .= "LEFT JOIN questions q ON ra.question_id = q.id ";
        $sql .= "WHERE ";
        $sql .= "r.published = 1 AND ";
		$sql .= "DATE_FORMAT(NOW(), '%Y-%m-%d 00:00:00') BETWEEN r.research_begin AND r.research_end ";
        $sql .= "GROUP BY q.name ";
        $sql .= "ORDER BY r.id DESC ";

        $researches = DB::select($sql);

        return $researches;

    }

    public function _getEvents() {

        $sql = "";
        $sql .= "SELECT ";
        $sql .= "p.event_id, ";
        $sql .= "e.title, ";
        $sql .= "CASE p.type ";
        $sql .= "  WHEN  'Yes' THEN 'Sim' ";
        $sql .= "  WHEN  'No' THEN 'Não' ";
        $sql .= "  ELSE 'Não' ";
        $sql .= "END AS label, ";
        $sql .= "count(*) as quantity ";
        $sql .= "FROM ";
        $sql .= "participations p ";
        $sql .= "LEFT JOIN events e ON p.event_id = e.id ";
        $sql .= "WHERE ";
        $sql .= "e.published = 1 AND ";
		$sql .= "DATE_FORMAT(NOW(), '%Y-%m-%d 00:00:00') BETWEEN e.enrollment_begin AND e.enrollment_end ";
        $sql .= "GROUP BY p.event_id, p.type ";
        $sql .= "ORDER BY p.event_id DESC ";

        $events = DB::select($sql);

        return $events;

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
