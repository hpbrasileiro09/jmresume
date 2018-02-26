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

class DumpController extends Controller
{

    public $path_view = 'dump';

    public $header_view = 'Dumps';

    public function index()
    {
        $page_header = $this->header_view;

        $ds = DIRECTORY_SEPARATOR;

        $dumpdir = storage_path() . $ds . 'dumps' . $ds;

        $dir = $dumpdir;

        $files1 = scandir($dir);

        krsort($files1);

        return view('admin.' . $this->path_view . '.index', 
            compact(
                'dir',
                'dumpdir',
                'files1',
                'page_header'
            ));
    }

    public function backup()
    {
        $ds = DIRECTORY_SEPARATOR;
        $exec = env('DB_DUMP', 'mysqldump');
        $host = env('DB_HOST', 'mysql.hpbtec.com.br'); 
        $username = env('DB_USERNAME', 'hpbtec_user'); 
        $schema = env('DB_DATABASE', 'hpbdev1_db');
        $password = env('DB_PASSWORD', 'g?CVsN-vVsN-v');
        $path = storage_path() . $ds . 'dumps' . $ds;
        $file = date("Ymd_His_").'Jmresume.sql';

        if ($password) {
            $command = sprintf('%s --add-drop-table %s -u %s --password=%s -h %s > %s', 
                $exec, $schema, $username, $password, $host, $path . $file);
        } else {
            $command = sprintf('%s --add-drop-table %s -u %s -h %s > %s', 
                $exec, $schema, $username, $host, $path . $file);
        }

        if (!is_dir($path)) {
            mkdir($path, 0755, true);
        }
        system($command);

        return response()->redirectToRoute($this->path_view . '.index');
    }

    public function store(Request $request)
    {
        return [
            'action' => 'store',
            'parameter' => $request.All(),
        ];        

    }

    public function show($id)
    {
        return [
            'action' => 'show',
            'parameter' => $id,
        ];        
    }

}
