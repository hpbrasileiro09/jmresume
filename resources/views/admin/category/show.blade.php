@extends('admin_template')

@section('content')

<?php echo $alert; ?>

<div class="row">

<div class="col-xs-8">

<div class="box box-primary">

    <div class="box-header with-border">
      <h3 class="box-title">&nbsp;Category Detail</h3>
      <div class="box-tools">
        <div class="input-group input-group-sm" style="width: 10px;">
          <div class="input-group-btn">
          	<a href="{{ route('category.index') }}" class="btn btn-primary">Back</a>
          </div>
        </div>
      </div>
    </div>
    <!-- /.box-header -->

	<div class="box-body">
	
		<h2><b>Description:</b>&nbsp;
		<pre><?php echo $prehtml ?></pre>
		</h2>

	</div>
	<!-- /.box-body -->

	<div class="box-footer">
	    <a href="{{ route('category.edit', $register->id) }}" class="btn btn-default pull-left">Edit</a>
		<form action="{{ route('category.destroy', $register->id) }}" class="form-horizontal" method="post">
			{!! csrf_field() !!}
			<input type="hidden" name="_method" value="DELETE">
			<input type="submit" value="remover" class="btn btn-default pull-right">
		</form>
	</div>
	<!-- /.box-footer -->

</div>

</div>

</div>

@endsection