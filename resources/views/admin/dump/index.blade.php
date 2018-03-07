@extends('admin_template')

@section('content')

      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">&nbsp;Backup Files</h3>
              <div class="box-tools">
                  <a href="{{ route('dump.backup') }}" class="btn btn-primary btn-xs">
                    <span class="glyphicon glyphicon-plus"></span>
                  </a>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
<?php
echo "<table class=\"table table-striped table-hover \">";
foreach($files1 as $k => $v) {
    
    $_data = explode("_", $v);
    $_timestamp = strtotime($_data[0]); 

    $pos = strpos($v, "Jmresume.sql");
    
    if (date('Y', $_timestamp) != date('Y')) continue;
    
    if ($pos === false) {
        echo "<tr><td><small>" . $k . "</small></td><td>&nbsp;</td><td>" . $v . "</td><td>&nbsp;</td><td>&nbsp;</td></tr>";
    } else {
        echo "<tr><td><small>" . $k . "</small></td><td><a href=\"/download/$v\"><span class=\"glyphicon glyphicon-download-alt\"></span></a></td><td>" . $v . "</td><td>" . date('d-m-Y H:i:s', $_timestamp) . "</td><td>" . filesize($dumpdir . $v)/1000 . "</td></tr>";
    }
    
}
echo "</table>";
?>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>

@endsection