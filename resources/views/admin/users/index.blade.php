@extends('admin_template')

@section('content')
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Administradores</h3>
              <div class="box-tools">
                <div class="input-group input-group-sm" style="width: 150px;">
                  <!--input type="text" name="table_search" class="form-control pull-right" placeholder="Search">
                  <div class="input-group-btn">
                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                    <a href="{{ route('users.create') }}" class="btn btn-primary btn-xs">
                      <span class="glyphicon glyphicon-plus"></span>
                    </a>            
                  </div-->
                </div>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tr>
                  <th>#</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Role</th>
                  <th class="text-right">Actions</th>
                </tr>
				@foreach($registers as $register)
					<tr>
						<td>{{ $register->id }}</td>
						<td>{{ $register->name }}</td>
						<td>{{ $register->email }}</td>
						<td>{{ $register->role }}</td>
						<td class="text-right">
							<a href="{{ route('users.edit', $register->id) }}" class="btn btn-default btn-xs">
								<span class="glyphicon glyphicon-pencil"></span>
							</a>
              <!--
							<a href="{{ route('users.show', $register->id) }}" class="btn btn-default btn-xs">
								<span class="glyphicon glyphicon-trash"></span>
							</a>
              -->
						</td>
					</tr>
				@endforeach
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          {{ $registers->links() }}
          <!-- /.box -->
        </div>
      </div>
@endsection