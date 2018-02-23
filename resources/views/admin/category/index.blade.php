@extends('admin_template')

@section('content')
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">&nbsp;Categories</h3>
              <div class="box-tools">
                <form action="{{ route('category.index') }}" method="GET" role="search">
                  <div class="input-group input-group-sm" style="width: 200px;">
                    <input type="text" name="search" class="form-control pull-right" value="{{$search}}" placeholder="Search">
                    <div class="input-group-btn">
                      <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                      <a href="{{ route('category.create') }}" class="btn btn-primary btn-xs">
                        <span class="glyphicon glyphicon-plus"></span>
                      </a>
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
                  <th>Name</th>
                  <th>Order</th>
                  <th>Type</th>
                  <th><font style='float: right;'>Value</font></th>
                  <th><font style='float: right;'>Day</font></th>
                </tr>
				@foreach($registers as $register)
					<tr>
            <td>
              <?php if ($register->id != 0) { ?>
              <a href="{{ route('category.show', $register->id) }}">
                <span class="glyphicon glyphicon-remove"></span>
              </a>
              &nbsp;&nbsp;&nbsp;
              <a href="{{ route('category.edit', $register->id) }}">
                <span class="glyphicon glyphicon-edit"></span>
              </a>
              <?php } ?>
            </td>
            <td>{{ $register->name }}</td>
            <td>{{ $register->ordem }}</td>
            <td>{{ $register->type }}</td>
            <td><?php echo \Helpers::trataValor($register->vl_prev, 1) ?></td>
            <td><font style='float: right; font-size:12px;'>{{ $register->day_prev }}</font></td>
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