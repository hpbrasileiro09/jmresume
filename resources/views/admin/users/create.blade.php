@extends('admin_template')

@section('content')

<div class="row">

<div class="col-xs-8">

<div class="box box-primary">

    <div class="box-header with-border">
      <h3 class="box-title">New User</h3>
      <div class="box-tools">
        <div class="input-group input-group-sm" style="width: 10px;">
          <div class="input-group-btn">
          <a href="{{ route('users.index') }}" class="btn btn-primary">voltar</a>
          </div>
        </div>
      </div>
    </div>
    <!-- /.box-header -->

	<form action="{{ route('users.store') }}" class="form-horizontal" method="post">
	<div class="box-body">	
	   	@include('admin.users.fcreate')
	</div>
	<!-- /.box-body -->	
	</form>

</div>

</div>

</div>

@endsection