
{!! csrf_field() !!}

<input type="hidden" name="label" id="label" class="form-control" value="{{ $register->label or '' }}">
<input type="hidden" name="default" id="default" class="form-control" value="{{ $register->default or '' }}">

<div class="form-group{{ $errors->has('value') ? ' has-error' : '' }}">
	<label for="value" class="control-label col-sm-2">Param</label>
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

<div class="form-group">
	<div class="col-sm-10 col-sm-offset-2">
		<input type="submit" value="Save" class="btn btn-primary" />
	</div>
</div>
