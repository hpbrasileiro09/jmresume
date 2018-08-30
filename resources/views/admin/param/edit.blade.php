@extends('admin_template')

@section('content')

<div class="row">

<div class="col-xs-8">

<div class="box box-primary">

    <div class="box-header with-border">
      <h3 class="box-title">&nbsp;Update Param</h3>
      <div class="box-tools">
        <div class="input-group input-group-sm" style="width: 10px;">
          <div class="input-group-btn">
          <a href="{{ route('param.show', $register->id) }}" class="btn btn-primary">Voltar</a>
          </div>
        </div>
      </div>
    </div>
    <!-- /.box-header -->

	<form action="{{ route('param.update', $register->id) }}" class="form-horizontal" method="post">
	<div class="box-body">
		<input type="hidden" name="_method" value="PUT">
	   	@include('admin.param.form')
	</div>
	</form>

</div>

</div>

</div>

@endsection