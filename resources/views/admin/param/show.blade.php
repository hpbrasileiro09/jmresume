@extends('admin_template')

@section('content')

<?php echo $alert; ?>

<div class="row">

<div class="col-xs-8">

<div class="box box-primary">

    <div class="box-header with-border">
      <h3 class="box-title">&nbsp;Entry Param</h3>
    </div>
    <!-- /.box-header -->

	<div class="box-body">
	
		<h2><b>Description:</b>&nbsp;
		<pre><?php echo $prehtml ?></pre>
		</h2>

	</div>
	<!-- /.box-body -->

	<div class="box-footer">
	    <a href="{{ route('param.edit', $register->id) }}" class="btn btn-default pull-left">Edit</a>
	</div>
	<!-- /.box-footer -->

</div>

</div>

</div>

@endsection