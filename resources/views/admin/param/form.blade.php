
{!! csrf_field() !!}

<div class="form-group{{ $errors->has('label') ? ' has-error' : '' }}">
	<label for="label" class="control-label col-sm-2">Label</label>
	<div class="col-sm-10">
		<input type="text" name="label" id="label" class="form-control" value="{{ $register->label or '' }}" placeholder="Label...">
	    @if ($errors->has('label'))
	        <span class="help-block">
	            <strong>{{ $errors->first('label') }}</strong>
	        </span>
	    @endif
	</div>
</div>

<div class="form-group{{ $errors->has('value') ? ' has-error' : '' }}">
	<label for="value" class="control-label col-sm-2">Value</label>
	<div class="col-sm-10">
		<input type="text" name="value" id="value" class="form-control" value="{{ $register->value or '' }}" placeholder="Value...">
	    @if ($errors->has('value'))
	        <span class="help-block">
	            <strong>{{ $errors->first('value') }}</strong>
	        </span>
	    @endif
	</div>
</div>

<div class="form-group{{ $errors->has('default') ? ' has-error' : '' }}">
	<label for="default" class="control-label col-sm-2">Default</label>
	<div class="col-sm-10">
		<input type="text" name="default" id="default" class="form-control" value="{{ $register->default or '' }}" placeholder="Default...">
	    @if ($errors->has('default'))
	        <span class="help-block">
	            <strong>{{ $errors->first('default') }}</strong>
	        </span>
	    @endif
	</div>
</div>

<div class="form-group">
	<div class="col-sm-10 col-sm-offset-2">
		<input type="submit" value="Save" class="btn btn-primary" />
	</div>
</div>
