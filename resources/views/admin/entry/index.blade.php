@extends('admin_template')

@section('content')
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">&nbsp;Entries</h3>
              <div class="box-tools">
                <form action="{{ route('entry.index') }}" method="GET" role="search">
                  <div class="input-group input-group-sm" style="width: 200px;">
                    <input type="text" name="search" class="form-control pull-right" value="{{$search}}" placeholder="Search">
                    <div class="input-group-btn">
                      <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                      <a href="{{ route('entry.create') }}" class="btn btn-primary btn-xs">
                        <span class="glyphicon glyphicon-plus"></span>
                      </a>
                    </div>
                  </div>
                </form>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tr>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th>Date</th>
                  <th>Description</th>
                  <th>Category</th>
                  <th><font style='float: right;'>Value</font></th>
                  <th><font style='float: right;'>Total</font></th>
                </tr>
                <?php

                  $i = 0;
                  $mes = 0;
                  $iphi = 0;
                  $total = 0;
                  $cartao = 0;

                  $_icone = '';
                  $scartao = '';
                  $_cartao = '';

                ?>
				@foreach($registers as $register)
                <?php

                  if ($i == 1) $mes = $register->mes;

                  if ($register->ds_subcategory == 'Visa' || $register->ds_subcategory == 'Mastercard') {
                      if ($register->status == 1) {
                          $cartao += $register->vl_entry;
                      }
                  } else
                      $cartao = 0;

                  $_class = "";

                  if ($mes != $register->mes) 
                  {
                      $mes = $register->mes;

                      $linhas = "";
                      $linhas .= "<tr class='info'>";
                      $linhas .= "<td colspan='8' align='right'>".\Helpers::getMonth($mes)."</td>";
                      $linhas .= "</tr>";
                      echo $linhas;
                  }

                  $_icone = $register->icone;
                  $_cartao = $register->cartao;
                  $scartao = ( $cartao != 0 ? \Helpers::trataValorC($cartao) : '' );

                  if ($register->dt_entry >= strftime("%Y-%m-%d 00:00:00",time()) && $iphi == 0)
                  {
                      $iphi = 1;
                  }

                  $iblack = 0;

                  if ($i == 0) $_class = "class='success'"; 
                  
                  if ($register->status == 1) {
                      $total += $register->vl_entry;
                  } else {
                      $iblack = 1;
                      $_class = "class='warning'";
                  }

                  if ($register->checked == 1) {
                      $iblack = 2;
                      $_class = "class='success'";
                  }

                ?>
					<tr <?php echo $_class ?> >
            <td>
              <?php if ($register->id != 0) { ?>
              <a href="{{ route('entry.show', $register->id) }}">
                <span class="glyphicon glyphicon-remove"></span>
              </a>
              &nbsp;&nbsp;&nbsp;
              <a href="{{ route('entry.edit', $register->id) }}">
                <span class="glyphicon glyphicon-edit"></span>
              </a>
              <?php } ?>
            </td>
						<td><?php echo $_icone ?></td>
            <td><?php echo \Helpers::trataDDS($register->dia_da_semana) ?></td>
            <td><?php echo \Helpers::trataDDS11($register->dt_entry_br) ?></td>
            <td><?php echo \Helpers::trataTexto($register->ds_category,11)."&nbsp;".\Helpers::trataTexto($register->ds_subcategory,11)."&nbsp;".$_cartao ?></td>
            <td><?php echo \Helpers::trataTexto($register->nm_category,11)."&nbsp;".\Helpers::trataTexto("(".$register->id_category.")",11)."&nbsp;".$scartao ?></td>
            <td><?php echo \Helpers::trataValor($register->vl_entry, 0) ?></td>
            <td><?php echo \Helpers::trataValor($total, 0) ?></td>
					</tr>
          <?php 
            $i++; 
          ?>
				@endforeach
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>
@endsection