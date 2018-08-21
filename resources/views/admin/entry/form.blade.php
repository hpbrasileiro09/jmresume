
{!! csrf_field() !!}

<input type="hidden" id="id_category" name="id_category" value="{{ $register->id_category or 0 }}">

<div class="form-group">
	<label for="id_category" class="control-label col-sm-2">Category</label>
	<div class="col-sm-10">
		<select id="id_category" name="id_category" class="form-control selectpicker id_category" data-live-search="true">
        @foreach($categories as $item)
			<option <?php echo ($item->id == $register->id_category ? 'selected="selected"' : ''); ?> value="{{$item->id}}">{{$item->name}}</option>
		@endforeach
		</select>
	</div>
</div>

<div class="form-group{{ $errors->has('ds_category') ? ' has-error' : '' }}">
	<label for="ds_category" class="control-label col-sm-2">Description</label>
	<div class="col-sm-10">
		<input type="text" name="ds_category" id="ds_category" class="form-control" value="{{ $register->ds_category or '' }}" placeholder="Description...">
	    @if ($errors->has('ds_category'))
	        <span class="help-block">
	            <strong>{{ $errors->first('ds_category') }}</strong>
	        </span>
	    @endif
	</div>
</div>

<div class="form-group{{ $errors->has('ds_subcategory') ? ' has-error' : '' }}">
	<label for="ds_subcategory" class="control-label col-sm-2">Sub Desc.</label>
	<div class="col-sm-10">
		<input type="text" name="ds_subcategory" id="ds_subcategory" class="form-control" value="{{ $register->ds_subcategory or '' }}" placeholder="Sub Desc...">
	    @if ($errors->has('ds_subcategory'))
	        <span class="help-block">
	            <strong>{{ $errors->first('ds_subcategory') }}</strong>
	        </span>
	    @endif
	</div>
</div>

<div class="form-group">
	<label for="ds_detail" class="control-label col-sm-2">Detail</label>
	<div class="col-sm-10">
		<textarea  name="ds_detail" rows="2" cols="80">{{ $register->ds_detail or '' }}</textarea>
	</div>
</div>

<div class="form-group{{ $errors->has('enrollment_begin') ? ' has-error' : '' }}">
	<label for="dt_entry" class="control-label col-sm-2">Date</label>
	<div class="col-sm-10">

        <div class="input-group date">
          <div class="input-group-addon">
            <i class="fa fa-calendar"></i>
          </div>
			<input type="text" name="dt_entry" id="dt_entry" class="dt_entry form-control pull-right" value="{{ $register->dt_entry or '' }}" placeholder="Date...">
        </div>
        <!-- /.input group -->

	    @if ($errors->has('enrollment_begin'))
	        <span class="help-block">
	            <strong>{{ $errors->first('enrollment_begin') }}</strong>
	        </span>
	    @endif
	</div>
</div>

<div class="form-group">
	<label for="vl_entry" class="control-label col-sm-2">Vl. Entry</label>
	<div class="col-sm-10">
		<div class="input-group">
            <span class="input-group-addon">R$</span>
				<input type="text" name="vl_entry" id="vl_entry" class="form-control" value="{{ $register->vl_entry or '0' }}" placeholder="Vl. Entry...">
            <span class="input-group-addon">.00</span>
        </div>		
	</div>
</div>

<div class="form-group">
    <label class="control-label col-sm-2"></label>
	<div class="col-sm-10">
      <div class="row" style="padding: 20px;">
        <div class="col-md-3">
      		<input type="checkbox" name="status" class="form-check-input" {{ ($register->status == 1 ? 'checked="checked"' : '' ) }} value="{{ $register->status or '0' }}">&nbsp;&nbsp;&nbsp;<b>Status</b>
        </div>
        <div class="col-md-3">
	      <input type="checkbox" name="fixed_costs" class="form-check-input" {{ ($register->fixed_costs == 1 ? 'checked="checked"' : '' ) }} value="{{ $register->fixed_costs or '0' }}">&nbsp;&nbsp;&nbsp;<b>Fixed</b>
        </div>
        <div class="col-md-3">
	      <input type="checkbox" name="checked" class="form-check-input" {{ ($register->checked == 1 ? 'checked="checked"' : '' ) }} value="{{ $register->checked or '0' }}">&nbsp;&nbsp;&nbsp;<b>Checked</b>
        </div>
        <div class="col-md-3">
	      <input type="checkbox" name="published" class="form-check-input" {{ ($register->published == 1 ? 'checked="checked"' : '' ) }} value="{{ $register->published or '0' }}">&nbsp;&nbsp;&nbsp;<b>Published</b>
        </div>
      </div>
    </div>
 </div>

<div class="form-group">
	<div class="col-sm-10 col-sm-offset-2">
		<input type="submit" value="Save" class="btn btn-primary" />
		<div style="float: right;"><b>Confirm create/update?</b>&nbsp;&nbsp;&nbsp;<input type="checkbox" name="confirm" class="form-check-input" value="0">&nbsp;&nbsp;&nbsp;</div>
	</div>
</div>
