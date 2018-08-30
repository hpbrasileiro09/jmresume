
{!! csrf_field() !!}

<input type="hidden" name="label" id="label" class="form-control" value="{{ $register->label or '' }}">
<input type="hidden" name="default" id="default" class="form-control" value="{{ $register->default or '' }}">
<input type="hidden" name="type" id="type" class="form-control" value="{{ $register->type or '' }}">

@if ($register->type == "datetime")
<div class="form-group{{ $errors->has('value') ? ' has-error' : '' }}">
	<label for="value" class="control-label col-sm-2">{{ $register->label or '' }}</label>
	<div class="col-sm-10">

	        <div class="input-group date">
	          <div class="input-group-addon">
	            <i class="fa fa-calendar"></i>
	          </div>
				<input type="text" name="value" id="value" class="dt_entry form-control pull-right" value="{{ $register->value or '' }}" placeholder="Date...">
	        </div>
	        <!-- /.input group -->
	    @if ($errors->has('value'))
	        <span class="help-block">
	            <strong>{{ $errors->first('value') }}</strong>
	        </span>
	    @endif
	
	</div>
</div>
@endif

@if ($register->type == "radio")
<div class="form-group{{ $errors->has('value') ? ' has-error' : '' }}">
	<label for="value" class="control-label col-sm-2">{{ $register->label or '' }}</label>
	<div class="col-sm-10">
		<div class="radio">
		  @if ($register->value == "0")
		  <label><input type="radio" name="value" value="0" checked>No</label>
 	      @else
		  <label><input type="radio" name="value" value="0">No</label>
 	      @endif
		</div>
		<div class="radio">
		  @if ($register->value == "1")
		  <label><input type="radio" name="value" value="1" checked>Yes</label>
 	      @else
		  <label><input type="radio" name="value" value="1">Yes</label>
 	      @endif
		</div>
	    @if ($errors->has('value'))
	        <span class="help-block">
	            <strong>{{ $errors->first('value') }}</strong>
	        </span>
	    @endif
	</div>
</div>	    
@else
<div class="form-group{{ $errors->has('value') ? ' has-error' : '' }}">
	<label for="value" class="control-label col-sm-2">{{ $register->label or '' }}</label>
	<div class="col-sm-10">
		<input type="text" name="value" id="value" class="form-control" value="{{ $register->value or '0' }}" placeholder="{{ $register->label or '' }}">
	    @if ($errors->has('value'))
	        <span class="help-block">
	            <strong>{{ $errors->first('value') }}</strong>
	        </span>
	    @endif
	</div>
</div>	    
@endif

<div class="form-group">
	<div class="col-sm-10 col-sm-offset-2">
		<input type="submit" value="Save" class="btn btn-primary" />
	</div>
</div>
