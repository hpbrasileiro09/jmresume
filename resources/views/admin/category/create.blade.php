@extends('admin_template')

@section('content')

<div class="row">

<div class="col-xs-8">

<div class="box box-primary">

    <div class="box-header with-border">
      <h3 class="box-title">&nbsp;Add Category</h3>
      <div class="box-tools">
        <div class="input-group input-group-sm" style="width: 10px;">
          <div class="input-group-btn">
          <a href="{{ route('category.index') }}" class="btn btn-primary">Back</a>
          </div>
        </div>
      </div>
    </div>
    <!-- /.box-header -->

	<form action="{{ route('category.store') }}" class="form-horizontal" method="post" enctype="multipart/form-data">
	<div class="box-body">
	   	@include('admin.category.form')
	</div>
	</form>

</div>

</div>

</div>

@endsection