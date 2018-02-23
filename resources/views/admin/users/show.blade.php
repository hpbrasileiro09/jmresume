@extends('admin_template')

@section('content')

<div class="row">

<div class="col-xs-8">


<div class="box box-primary">

    <div class="box-header with-border">
      <h3 class="box-title">Show Associated</h3>
      <div class="box-tools">
        <div class="input-group input-group-sm" style="width: 10px;">
          <div class="input-group-btn">
          <a href="{{ route('users.index') }}" class="btn btn-primary">voltar</a>
          </div>
        </div>
      </div>
    </div>
    <!-- /.box-header -->

	<div class="box-body">

		<h3>{{ $register->name }}</h3>

		<h4>{{ $register->email }}</h4>

		<p>
			<small>
				Criado em {{ $register->created_at->format('d-m-Y H:i:s') }} | Atualizado em {{ $register->updated_at->format('d-m-Y H:i:s') }}
			</small>
		</p>
		
		{!! $register->comment !!}

	</div>
	<!-- /.box-body -->

	<div class="box-footer">
	    <a href="{{ route('users.edit', $register->id) }}" class="btn btn-default pull-left">editar</a>
		<form action="{{ route('users.destroy', $register->id) }}" class="form-horizontal" method="post">
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