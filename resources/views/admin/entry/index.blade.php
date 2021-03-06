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
                <?php if ($rb_modal == "1") { ?>
                  &nbsp;&nbsp;&nbsp;
                  <a  href="#" id="w_<?php echo $register->id; ?>" class="itemModal" role="button" data-target="#myModal" data-toggle="modal">
                    <span class="glyphicon glyphicon-edit"></span>
                  </a>
                <?php } else { ?>
                  &nbsp;&nbsp;&nbsp;
                  <a href="{{ route('entry.edit', $register->id) }}">
                    <span class="glyphicon glyphicon-edit"></span>
                  </a>
                <?php } ?>
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

        <!-- Modal -->
        <div id="myModal" class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title">Update Entry&nbsp;<span id="id_badge" class="badge badge-primary">0</span></h4>
                    </div>
                    <div class="modal-body">

                        <form class="form-horizontal" id="translate" name="translate" action="#" method="post">
                        <input type='hidden' name='id' id='id' value='0' />
                            <fieldset>
                                <div class="form-group">
                                    <label for="id_category" class="col-lg-2 control-label">Category</label>
                                    <div class="col-lg-10">
                                        <select id="id_category" name="id_category" class="form-control selectpicker id_category" data-live-search="true">
                                            @foreach($m_categories as $item)
                                          <option value="{{$item->id}}">{{$item->name}}</option>
                                        @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="ds_category" class="col-lg-2 control-label">Description</label>
                                    <div class="col-lg-10">
                                        <input type='text' class="form-control" name='ds_category' id='ds_category' value='' placeholder='Description...' />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="ds_subcategory" class="col-lg-2 control-label">Sub Desc.</label>
                                    <div class="col-lg-10">
                                        <input type='text' class="form-control" name='ds_subcategory' id='ds_subcategory' value='' placeholder='Sub Desc....' />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="vl_entry" class="col-lg-2 control-label">Detail</label>
                                    <div class="col-lg-10">
                                        <textarea class="form-control" name='ds_detail' id='ds_detail' placeholder='Detail...'></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="dt_entry" class="col-lg-2 control-label">Date</label>
                                    <div class="col-lg-10">
                                        <div class="input-group date">
                                          <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                          </div>
                                          <input type="text" name="dt_entry" id="dt_entry" class="dt_entry form-control pull-right" value="" placeholder="Dt. Entry...">
                                        </div>
                                        <!-- /.input group -->
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="vl_entry" class="col-lg-2 control-label">Vl. Entry</label>
                                    <div class="col-lg-10">
                                        <div class="input-group">
                                        <span class="input-group-addon">R$</span>
                                        <input type="text" name="vl_entry" id="vl_entry" class="form-control" value="" placeholder="Vl. Entry...">
                                        <span class="input-group-addon">.00</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="status" class="col-lg-2 control-label"></label>
                                    <div class="col-lg-10">
                                      <div class="row" style="padding: 20px;">
                                        <div class="col-md-3"><?php echo $rb_status; ?></div>
                                        <div class="col-md-3"><?php echo $rb_fixed_costs; ?></div>
                                        <div class="col-md-3"><?php echo $rb_checked; ?></div>
                                        <div class="col-md-3"><?php echo $rb_published; ?></div>
                                      </div>
                                    </div>
                                </div>
                            </fieldset>
                            <input type="hidden" name="acao" id="acao" value="dummy" />

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btnSubmit" id="submit">Save changes</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <form id="lastdscategory" name="lastdscategory" action="#" method="post">
            <input type="hidden" name="id_category" id="id_category" value="0" />
        </form>

<script>
  $(function () {

    $('#id_category').on('change', function() {
        $('#lastdscategory input:hidden[id=id_category]').val( $(this).val() );
        lastDsCategory();
    });

    var lastDsCategory = function( ) {
        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: '/time/' + $('#lastdscategory input:hidden[id=id_category]').val(),
            data: $("form[id=lastdscategory]").serialize(),
            success: function(data) {
                $.each(data, function(key, value){
                    $('input:text[id=ds_category]').val(value.ds_category);    
                    $('input:text[id=ds_subcategory]').val(value.ds_subcategory);    
                });
            },       
            error: function(jqXHR, textStatus, errorThrown) {  
                $("#msg").html('failure! please verify');
            }              
        });         
    };

    var translateF = function($id) {
        console.log('translateF[' + $id + ']');
        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: '/entry/json/' + $id,
            data: $("form[id=translate]").serialize(),
            success: function(data) {
                $.each(data, function(key, value){
                    $('#id').val($id);
                    $('#id_badge').text($id);
                    $('.dt_entry').datepicker('update', value.dt_entry_br);
                    $('#translate input:text[id=ds_category]').val(value.ds_category);    
                    $('#translate input:text[id=ds_subcategory]').val(value.ds_subcategory);    
                    $('#translate #ds_detail').val(value.ds_detail);    
                    $("#id_category option[value='" + value.id_category + "']").attr("selected","selected");  
                    $('.selectpicker').selectpicker('refresh');
                    $('#translate input:text[id=vl_entry]').val(value.vl_entry); 
                    if (value.status == 1)
                        $('#translate input:checkbox[id=status]').attr('checked', true); 
                    if (value.fixed_costs == 1)
                        $('#translate input:checkbox[id=fixed_costs]').attr('checked', true);    
                    if (value.checked == 1)
                        $('#translate input:checkbox[id=checked]').attr('checked', true);    
                    if (value.published == 1)
                        $('#translate input:checkbox[id=published]').attr('checked', true);  
                });
            },       
            error: function(jqXHR, textStatus, errorThrown) {  
                console.log('_nok_');
            }    
        });
    };

    var translateS = function( ) {
        console.log('translateS[' + $('#translate input:text[id=id]').val() + ']');
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: '/entry/save',
            data: $("form[id=translate]").serialize(),
            success: function(data) {
                console.log('_ok_');
            },
            error: function(jqXHR, textStatus, errorThrown) {  
                console.log('_nok_');
            },
            always: function(data) {
                console.log('_always_');
                location.reload();
            }              
        });
    };

    $(".itemModal").click(function(ev) {
        $('#translate input:hidden[id=acao]').val('dummy');    
        ev.preventDefault();
        var elem = $(this).attr("id").split('_');
        $('#translate input:text[id=id]').val(elem[1]); 
        translateF(elem[1]);  
    });

    $(".btnSubmit").click(function(ev) {            
        $('#translate input:hidden[id=acao]').val('salvar');    
        translateS();  
        ev.preventDefault();
        $('#myModal').modal('hide');
        console.log('_btnsubmit_');
        location.reload();
    });

  });
</script>

@endsection