@extends('admin_template')

@section('content')

<div class="row">

<div class="col-xs-8">

<div class="box box-primary">

    <div class="box-header with-border">
      <h3 class="box-title">&nbsp;Update Category</h3>
      <div class="box-tools">
        <div class="input-group input-group-sm" style="width: 10px;">
          <div class="input-group-btn">
          <a href="{{ route('category.index') }}" class="btn btn-primary">Back</a>
          </div>
        </div>
      </div>
    </div>
    <!-- /.box-header -->

	<form action="{{ route('category.update', $register->id) }}" class="form-horizontal" method="post">
	<div class="box-body">
		<input type="hidden" name="_method" value="PUT">
	   	@include('admin.category.form')
	</div>
	</form>

</div>

</div>

</div>

@endsection