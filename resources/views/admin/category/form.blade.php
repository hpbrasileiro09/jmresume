
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

<div class="form-group{{ $errors->has('ordem') ? ' has-error' : '' }}">
	<label for="ordem" class="control-label col-sm-2">Order</label>
	<div class="col-sm-10">
		<input type="text" name="ordem" id="ordem" class="form-control" value="{{ $register->ordem or '0' }}" placeholder="Order...">
	    @if ($errors->has('ordem'))
	        <span class="help-block">
	            <strong>{{ $errors->first('ordem') }}</strong>
	        </span>
	    @endif
	</div>
</div>

<div class="form-group{{ $errors->has('day_prev') ? ' has-error' : '' }}">
	<label for="day_prev" class="control-label col-sm-2">Day</label>
	<div class="col-sm-10">
		<input type="text" name="day_prev" id="day_prev" class="form-control" value="{{ $register->day_prev or '0' }}" placeholder="Day...">
	    @if ($errors->has('day_prev'))
	        <span class="help-block">
	            <strong>{{ $errors->first('day_prev') }}</strong>
	        </span>
	    @endif
	</div>
</div>

<div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
	<label for="type" class="control-label col-sm-2">Type</label>
	<div class="col-sm-10">
		<input type="text" name="type" id="type" class="form-control" value="{{ $register->type or '' }}" placeholder="Type...">
	    @if ($errors->has('type'))
	        <span class="help-block">
	            <strong>{{ $errors->first('type') }}</strong>
	        </span>
	    @endif
	</div>
</div>

<div class="form-group">
	<label for="vl_prev" class="control-label col-sm-2">Value</label>
	<div class="col-sm-10">
		<div class="input-group">
            <span class="input-group-addon">R$</span>
				<input type="text" name="vl_prev" id="vl_prev" class="form-control" value="{{ $register->vl_prev or '0' }}" placeholder="Value...">
            <span class="input-group-addon">.00</span>
        </div>		
	</div>
</div>

<div class="form-group">
    <label class="control-label col-sm-2">
    </label>
	<div class="col-sm-10">
      <input type="checkbox" name="published" class="form-check-input" {{ ($register->published == 1 ? 'checked="checked"' : '' ) }} value="{{ $register->published or '0' }}">&nbsp;&nbsp;&nbsp;<b>Published</b>
    </div>
 </div>

<div class="form-group">
	<div class="col-sm-10 col-sm-offset-2">
		<input type="submit" value="Save" class="btn btn-primary" />
	</div>
</div>
