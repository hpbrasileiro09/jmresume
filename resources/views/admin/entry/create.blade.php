@extends('admin_template')

@section('content')

<div class="row">

<div class="col-xs-8">

<div class="box box-primary">

    <div class="box-header with-border">
      <h3 class="box-title">&nbsp;Add Entry</h3>
      <div class="box-tools">
        <div class="input-group input-group-sm" style="width: 10px;">
          <div class="input-group-btn">
          <a href="{{ route('entry.index') }}" class="btn btn-primary">Back</a>
          </div>
        </div>
      </div>
    </div>
    <!-- /.box-header -->

	<form action="{{ route('entry.store') }}" class="form-horizontal" method="post" enctype="multipart/form-data">
	<div class="box-body">
	   	@include('admin.entry.form')
	</div>
	</form>

  <form id="lastdscategory" name="lastdscategory" action="#" method="post">
    <input type="hidden" name="id_category" id="id_category" value="0" />
  </form> 

</div>

</div>

</div>

<script>
  $(function () {
    $('.id_category').on('change', function() {
        alert('teste');
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
  });
</script>

@endsection