@extends('admin_template')

@section('content')
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">&nbsp;Params</h3>
              <div class="box-tools">
                <form action="{{ route('param.index') }}" method="GET" role="search">
                  <div class="input-group input-group-sm" style="width: 200px;">
                    <div class="input-group-btn">
                    </div>
                  </div>
                </form>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tr>
                  <th></th>
                  <th>#Id</th>
                  <th>Label</th>
                  <th>Type</th>
                  <th>Value</th>
                </tr>
				@foreach($registers as $register)
					<tr>
            <td>
              <?php if ($register->id != 0) { ?>
              <a href="{{ route('param.edit', $register->id) }}">
                <span class="glyphicon glyphicon-edit"></span>
              </a>
              <?php } ?>
            </td>
            <td>{{ $register->id }}</td>
            <td>{{ $register->label }}</td>
            <td>{{ $register->type }}</td>
            <td>{{ $register->value }}</td>
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