@extends('admin_template')

@section('content')

<div class="row">

<div class="col-xs-8">

<div class="box box-primary">

    <div class="box-header with-border">
      <h3 class="box-title">Meus Dados</h3>
      <div class="box-tools">
        <div class="input-group input-group-sm" style="width: 10px;">
          <div class="input-group-btn">
          </div>
        </div>
      </div>
    </div>
    <!-- /.box-header -->

	<div class="box-body">
		<h1><b>Nome:</b>&nbsp;{{ $user->name }}</h1>

		<h1><b>Email:</b>&nbsp;{{ $user->email }}</h1>

		<h2><b>Tipo:</b>&nbsp;{{ \Helpers::transRole($user->role) }}</h2>

		<p>
			<small>
				Criado em {{ $user->created_at->format('d-m-Y H:i:s') }} | Atualizado em {{ $user->updated_at->format('d-m-Y H:i:s') }}
			</small>
		</p>
	</div>
	<!-- /.box-body -->

	<div class="box-footer">
	    <a href="{{ route('person.edit', $user->id) }}" class="btn btn-default pull-left">Editar</a>
	</div>
	<!-- /.box-footer -->

</div>

</div>

</div>

@endsection