
{!! csrf_field() !!}

<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
	<label for="name" class="control-label col-sm-2">Name</label>
	<div class="col-sm-10">
		<input type="text" name="name" id="name" class="form-control" value="{{ $register->name or '' }}" placeholder="Name...">
	    @if ($errors->has('name'))
	        <span class="help-block">
	            <strong>{{ $errors->first('name') }}</strong>
	        </span>
	    @endif
	</div>
</div>

<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
	<label for="email" class="control-label col-sm-2">Email</label>
	<div class="col-sm-10">
		<input type="text" name="email" id="email" class="form-control" value="{{ $register->email or '' }}" placeholder="Email...">
	    @if ($errors->has('email'))
	        <span class="help-block">
	            <strong>{{ $errors->first('email') }}</strong>
	        </span>
	    @endif
	</div>
</div>

<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
    <label for="password" class="control-label col-md-2">Password</label>
    <div class="col-md-10">
        <input id="password" type="password" class="form-control" name="password" placeholder="Password...">
        @if ($errors->has('password'))
            <span class="help-block">
                <strong>{{ $errors->first('password') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
    <label for="password-confirm" class="control-label col-md-2">Confirm Password</label>
    <div class="col-md-10">
        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Password confirmation...">
        @if ($errors->has('password_confirmation'))
            <span class="help-block">
                <strong>{{ $errors->first('password_confirmation') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group">
	<label for="role" class="control-label col-sm-2">Role</label>
	<div class="col-sm-10">
		<input type="text" name="role" id="role" class="form-control" value="{{ $register->role or '' }}" placeholder="Role..." readonly="readonly">
	</div>
</div>

<div class="form-group">
	<label for="published" class="control-label col-sm-2">Published</label>
	<div class="col-sm-10">
		<select name="published" class="form-control">
			@foreach ($published as $item)
			<option <?php echo ($register->published == $item['value'] ? 'selected="selected"' : ''); ?> value="{{$item['value']}}">{{$item['label']}}</option>
			@endforeach
		</select>
	</div>
</div>

<div class="form-group">
	<div class="col-sm-10 col-sm-offset-2">
		<input type="submit" value="Save" class="btn btn-primary" />
	</div>
</div>
