@extends('admin_template')

@section('content')
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">&nbsp;Entries</h3>
              <div class="box-tools">
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
            
                <table class="table table-striped table-hover">
                    <thead>
                      <tr>
                            <th scope="col"></th>
                            <th scope="col"><font style='float: left;'>Categoria&nbsp;<?php echo $ano; ?></font></th>
                            <th scope="col"></th>
                            <?php
                            $txtcsv = "";
                            $txtcsv .= ";";
                            $txtcsv .= ";";
                            $txtcsv .= ";";
                            foreach($mesesG as $lmes) 
                            {
                                $txtcsv .= $lmes['abrev'].";";
                                echo "<th scope=\"col\"><font style='float: right;'>".$lmes['abrev']."</font></th>";
                            }
                            ?>
                        </tr>
                    </thead>
                        <tfoot>
                      <tr>
                          <td colspan="14"><em>Jm Detalhe&nbsp;<?php echo $ano; ?></em></td>
                          <td>&nbsp;</td>
                        </tr>
                    </tfoot>
                    <tbody>


                <?php 

    function trataTextoSize($ptext,$psize=8) {
      return "<font style='font-size:".$psize."px;'>".$ptext."</font>";
    }

    function setStatus($_temp, $_cor) {
        $resp = $_cor;
        if ($_temp) $resp = "grey";
        if ($_temp==2) $resp = "green";
        return $resp;
    }

    function trataValor($pvalor, $iblack=0)
    {
      $resp = number_format($pvalor, 2, ',', '.');
      $cor = "green";
      if ($pvalor < 0) $cor = "red";
      $cor = setStatus($iblack, $cor);
      $_return = "<font style='float: right; font-size:11px;' color='" . $cor . "'>" . $resp . "</font>"; 
      if ($pvalor == 0) $_return = "<font style='float: right; font-size:11px;' color='" . $cor . "'>_</font>"; 
      return $_return;
    }

    function trataValorB($pvalor)
    {
      $resp = number_format($pvalor, 2, ',', '.');
      $cor = "blue";
      if ($pvalor < 0) $cor = "blue";
      $_return = "<font style='float: right; font-size:9px;' color='" . $cor . "'>" . $resp . "</font>"; 
      if ($pvalor == 0) $_return = "<font style='float: right; font-size:9px;' color='" . $cor . "'></font>"; 
      return $_return;
    }

    function trataValorA($pvalor, $ano, $mes, $cat, $deb=0, $vl_prev=0)
    {
      $path = 'http://'.$_SERVER['HTTP_HOST'].'/reports/lupa?ano='.$ano.'&mes='.$mes.'&cat='.$cat.'&deb='.$deb;
      $resp = number_format($pvalor, 2, ',', '.');
      $cor = "green";
      if ($pvalor < 0) $cor = "red";
      if ($vl_prev) $cor = "blue";
      if ($pvalor == 0) $resp = "-";
      $_return = "<font style='float: right; font-size:11px;' color='" . $cor . "'>" . $resp . "</font>"; 
      //if (!$vl_prev) $_return = '<a href="'.$path.'">'.$_return.'</a>';
      if (!$vl_prev) $_return = '<a href="#myModalX" path="'.$path.'" role="button" data-toggle="modal">'.$_return.'</a>';      
      return $_return;
    }

                $jan = Array();
                $fev = Array();
                $mar = Array();
                $abr = Array();
                $mai = Array();
                $jun = Array();
                $jul = Array();
                $ago = Array();
                $set = Array();
                $out = Array();
                $nov = Array();
                $dez = Array();

                foreach($categoriesC as $category)
                {

                    $item = Array();
                    $item['tipo'] = 'C'; 
                    $item['ordem'] = $category->ordem; 
                    $item['name'] = $category->name; 
                    $item['category_id'] = $category->id; 
                    $item['vl_prev'] = $category->vl_prev; 

                    $x=1;
                    foreach($mesesG as $lmes) 
                    {
                        $vl_entry = 0;
                        foreach($creditos as $entry)
                        {
                            if ($entry->mes == $lmes['id'] && $entry->ano == $lmes['ano'] && $entry->id_category == $category->id) 
                            {
                                $vl_entry += $entry->vl_entry;
                            }
                        }
                        if ($x ==  1) $jan[] = $vl_entry;
                        if ($x ==  2) $fev[] = $vl_entry;
                        if ($x ==  3) $mar[] = $vl_entry;
                        if ($x ==  4) $abr[] = $vl_entry;
                        if ($x ==  5) $mai[] = $vl_entry;
                        if ($x ==  6) $jun[] = $vl_entry;
                        if ($x ==  7) $jul[] = $vl_entry;
                        if ($x ==  8) $ago[] = $vl_entry;
                        if ($x ==  9) $set[] = $vl_entry;
                        if ($x == 10) $out[] = $vl_entry;
                        if ($x == 11) $nov[] = $vl_entry;
                        if ($x == 12) $dez[] = $vl_entry;

                        $item['M'.$x] = $vl_entry; 
                        $item['MA'.$x] = $lmes['ano']; 
                        $item['MI'.$x] = $lmes[ 'id']; 
                        $item['VP'.$x] = 0; 

                        $x++;
                    }

                    $geral[] = $item;

                }

                foreach($geral as $gitem)
                {

                    if ($gitem['tipo'] != 'C') continue;
                    
                    $xvalue = 0;
                    for ($z=1; $z<=12; $z++) {
                        $xvalue += $gitem['M'.$z];
                    }

                    if ($xvalue == 0) continue;

                    echo "<tr>";
                    echo "<td>".trataTextoSize($gitem['ordem'])."</td>";
                    echo "<td>".$gitem['name'].'&nbsp;('.trataTextoSize($gitem['category_id']).")</td>";
                    echo "<td>".trataValorB($gitem['vl_prev'])."</td>";
                    for ($z=1; $z<=12; $z++) {
                        echo "<td>".trataValorA($gitem['M'.$z], $gitem['MA'.$z], $gitem['MI'.$z], $gitem['category_id'])."</td>";
                    }
                    echo "</tr>";

                }

                $creditosT = Array();

                ?>

                    <tr>
                        <td><em></em></td>
                        <td><em>Cr&eacute;dito</em></td>
                        <td><em></em></td>
                        <?php
                        $tval = 0;
                        foreach($jan as $vval) $tval += $vval;
                        $creditosT[] = $tval;
                        echo "<td>".trataValor($tval)."</td>";
                        $tval = 0;
                        foreach($fev as $vval) $tval += $vval;
                        $creditosT[] = $tval;
                        echo "<td>".trataValor($tval)."</td>";
                        $tval = 0;
                        foreach($mar as $vval) $tval += $vval;
                        $creditosT[] = $tval;
                        echo "<td>".trataValor($tval)."</td>";
                        $tval = 0;
                        foreach($abr as $vval) $tval += $vval;
                        $creditosT[] = $tval;
                        echo "<td>".trataValor($tval)."</td>";
                        $tval = 0;
                        foreach($mai as $vval) $tval += $vval;
                        $creditosT[] = $tval;
                        echo "<td>".trataValor($tval)."</td>";
                        $tval = 0;
                        foreach($jun as $vval) $tval += $vval;
                        $creditosT[] = $tval;
                        echo "<td>".trataValor($tval)."</td>";
                        $tval = 0;
                        foreach($jul as $vval) $tval += $vval;
                        $creditosT[] = $tval;
                        echo "<td>".trataValor($tval)."</td>";
                        $tval = 0;
                        foreach($ago as $vval) $tval += $vval;
                        $creditosT[] = $tval;
                        echo "<td>".trataValor($tval)."</td>";
                        $tval = 0;
                        foreach($set as $vval) $tval += $vval;
                        $creditosT[] = $tval;
                        echo "<td>".trataValor($tval)."</td>";
                        $tval = 0;
                        foreach($out as $vval) $tval += $vval;
                        $creditosT[] = $tval;
                        echo "<td>".trataValor($tval)."</td>";
                        $tval = 0;
                        foreach($nov as $vval) $tval += $vval;
                        $creditosT[] = $tval;
                        echo "<td>".trataValor($tval)."</td>";
                        $tval = 0;
                        foreach($dez as $vval) $tval += $vval;
                        $creditosT[] = $tval;
                        echo "<td>".trataValor($tval)."</td>";
                        ?>
                    </tr>

                <?php

                $jan = Array();
                $fev = Array();
                $mar = Array();
                $abr = Array();
                $mai = Array();
                $jun = Array();
                $jul = Array();
                $ago = Array();
                $set = Array();
                $out = Array();
                $nov = Array();
                $dez = Array();

        $geral = Array();

                foreach($categoriesD as $category)
                {

                    $item = Array();
                    $item['tipo'] = 'D'; 
                    $item['ordem'] = $category->ordem; 
                    $item['name'] = $category->name; 
                    $item['category_id'] = $category->id; 
                    $item['vl_prev'] = $category->vl_prev; 

                    $x=1;
                    foreach($mesesG as $lmes) 
                    {
                        $vl_prev = 0;
                        $vl_entry = 0;
                        foreach($debitos as $entry)
                        {
                            if ($entry->mes == $lmes['id'] && $entry->ano == $lmes['ano'] && 
                                $entry->id_category == $category->id) 
                            {
                                $vl_entry += $entry->vl_entry;
                            }
                        }
                        if ($vl_entry == 0) {
                            if ($category->vl_prev != 0) {
                                $vl_entry = $category->vl_prev;
                                $vl_prev = 1;
                            }
                        }
                        if ($x ==  1) $jan[] = $vl_entry;
                        if ($x ==  2) $fev[] = $vl_entry;
                        if ($x ==  3) $mar[] = $vl_entry;
                        if ($x ==  4) $abr[] = $vl_entry;
                        if ($x ==  5) $mai[] = $vl_entry;
                        if ($x ==  6) $jun[] = $vl_entry;
                        if ($x ==  7) $jul[] = $vl_entry;
                        if ($x ==  8) $ago[] = $vl_entry;
                        if ($x ==  9) $set[] = $vl_entry;
                        if ($x == 10) $out[] = $vl_entry;
                        if ($x == 11) $nov[] = $vl_entry;
                        if ($x == 12) $dez[] = $vl_entry;

                        $item['M'.$x] = $vl_entry; 
                        $item['MA'.$x] = $lmes['ano']; 
                        $item['MI'.$x] = $lmes['id']; 
                        $item['VP'.$x] = $vl_prev; 

                        $x++;
                    }

                    $geral[] = $item;

                }

                foreach($geral as $gitem)
                {

                    if ($gitem['tipo'] != 'D') continue;

                    $xvalue = 0;
                    for ($z=1; $z<=12; $z++) {
                        $xvalue += $gitem['M'.$z];
                    }

                    if ($xvalue == 0) continue;

                    echo "<tr>";
                    echo "<td>".trataTextoSize($gitem['ordem'])."</td>";
                    echo "<td>".utf8_encode($gitem['name']).'&nbsp;('.trataTextoSize($gitem['category_id']).")</td>";
                    echo "<td>".trataValorB($gitem['vl_prev'])."</td>";
                    for ($z=1; $z<=12; $z++) {
                        echo "<td>".trataValorA($gitem['M'.$z], $gitem['MA'.$z], $gitem['MI'.$z], $gitem['category_id'], 1, $gitem['VP'.$z])."</td>";
                    }
                    echo "</tr>";

                }

                $debitosT = Array();

                ?>

                    <tr>
                        <td><em></em></td>
                        <td><em>D&eacute;bito</em></td>
                        <?php
                        echo "<td>".trataValorB($tprev)."</td>";
                        $tval = 0;
                        foreach($jan as $vval) $tval += $vval;
                        $debitosT[] = $tval;
                        echo "<td>".trataValor($tval)."</td>";
                        $tval = 0;
                        foreach($fev as $vval) $tval += $vval;
                        $debitosT[] = $tval;
                        echo "<td>".trataValor($tval)."</td>";
                        $tval = 0;
                        foreach($mar as $vval) $tval += $vval;
                        $debitosT[] = $tval;
                        echo "<td>".trataValor($tval)."</td>";
                        $tval = 0;
                        foreach($abr as $vval) $tval += $vval;
                        $debitosT[] = $tval;
                        echo "<td>".trataValor($tval)."</td>";
                        $tval = 0;
                        foreach($mai as $vval) $tval += $vval;
                        $debitosT[] = $tval;
                        echo "<td>".trataValor($tval)."</td>";
                        $tval = 0;
                        foreach($jun as $vval) $tval += $vval;
                        $debitosT[] = $tval;
                        echo "<td>".trataValor($tval)."</td>";
                        $tval = 0;
                        foreach($jul as $vval) $tval += $vval;
                        $debitosT[] = $tval;
                        echo "<td>".trataValor($tval)."</td>";
                        $tval = 0;
                        foreach($ago as $vval) $tval += $vval;
                        $debitosT[] = $tval;
                        echo "<td>".trataValor($tval)."</td>";
                        $tval = 0;
                        foreach($set as $vval) $tval += $vval;
                        $debitosT[] = $tval;
                        echo "<td>".trataValor($tval)."</td>";
                        $tval = 0;
                        foreach($out as $vval) $tval += $vval;
                        $debitosT[] = $tval;
                        echo "<td>".trataValor($tval)."</td>";
                        $tval = 0;
                        foreach($nov as $vval) $tval += $vval;
                        $debitosT[] = $tval;
                        echo "<td>".trataValor($tval)."</td>";
                        $tval = 0;
                        foreach($dez as $vval) $tval += $vval;
                        $debitosT[] = $tval;
                        echo "<td>".trataValor($tval)."</td>";
                        ?>
                    </tr>

                    <tr>
                        <td><em></em></td>
                        <td><em></em></td>
                        <td><em></em></td>
                <?php
                $x=0;
                foreach($creditosT as $icred)
                {
                    $resp = $icred + $debitosT[$x++];
                    echo "<td>".trataValor($resp)."</td>";
                }
                ?>
                    </tr>                

                </tbody>
              </table>

                <!-- Modal -->
                <div id="myModalX" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog" style="max-width: 100%; max-height: 100%; height: auto; display: table;">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>
                            <div class="modal-body">
                                <iframe width="100%" height="100%" frameborder="0" scrolling="yes" marginheight="0" marginwidth="0" id="ifrm" src="#"></iframe>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal -->

            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>

<script>
  $(function () {

    $("a[href=\\#myModalX]").click(function(ev) {

        ev.preventDefault();

        var path = $(this).attr("path");

        $('#ifrm').attr('src', path);

        $('#ifrm').css('height',$(window).height()*0.6);

        //$('.modal-content').css('height',$( window ).height()*0.4);

    });

  });
</script>

@endsection