@extends('admin_template')

@section('content')

<?php echo $alert; ?>

      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">
              <div class="row-10">
                <div class="col-2"><input type="checkbox" id="select_all_" value="1" />
                &nbsp;Entries Support</div>
              </div>
              </h3>
              <div class="box-tools">
                <form action="{{ route('entry.support') }}" method="GET" role="search">
                  <div class="input-group input-group-sm" style="width: 300px;">
                    <input type="text" name="search" class="form-control pull-right" value="{{$search}}" placeholder="Search">
                    <div class="input-group-btn">
                      <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                      <a href="{{ route('entry.support') }}" class="btn btn-danger btn-xs">
                        <span class="glyphicon glyphicon-refresh"></span>
                      </a>
                      <a href="#" class="btnSubmit btn btn-info btn-xs">Save</a>
                    </div>
                  </div>
                </form>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">

<form id="fsupport" name="fsupport" action="{{ route('entry.supportsave') }}" method="post" enctype="multipart/form-data">

				@foreach($registers as $register)

            <div class="form-inline">

                <div class="form-check form-control">
                  <input class="form-check-input check_ chkBX" class="form-control" type="checkbox" value="<?php echo $register->id; ?>" id="chkbox" name="chkbox">
                  <label class="form-check-label" for="defaultCheck1">
                    &nbsp;<font style='font-size:10px;'>#<?php echo str_pad($register->id, 6, "0", STR_PAD_LEFT); ?></font>
                  </label>                
                </div>

                <input type="text" style="width: 22%;" id="<?php echo $register->id; ?>_ds_category" name="<?php echo $register->id; ?>_ds_category" class="form-control" value="<?php echo $register->ds_category; ?>">

                <input type="text" id="<?php echo $register->id; ?>_ds_subcategory" name="<?php echo $register->id; ?>_ds_subcategory" class="form-control" value="<?php echo $register->ds_subcategory; ?>">

                <input type="text" style="width: 142px;" id="<?php echo $register->id; ?>_dt_entry" name="<?php echo $register->id; ?>_dt_entry" class="form-control" value="<?php echo $register->dt_entry; ?>">

                <input type="text" style="width: 90px;" id="<?php echo $register->id; ?>_vl_entry" name="<?php echo $register->id; ?>_vl_entry" class="form-control" value="<?php echo $register->vl_entry; ?>">

                <?php echo \Helpers::MontaCategories($mcategories, $register->id."_id_category", $register->id_category, 0); ?>

                <div class="form-check form-control">
                  
                  <input title="status" class="chk_status form-check-input" type="checkbox" class="form-control" <?php echo ($register->status == 1 ? 'checked="checked"' : ''); ?> value="<?php echo $register->status; ?>" id="<?php echo $register->id; ?>_status" name="<?php echo $register->id; ?>_status">
                  
                  <input title="checked" class="form-check-input" type="checkbox" class="chk_checked form-control" <?php echo ($register->checked == 1 ? 'checked="checked"' : ''); ?> value="<?php echo $register->checked; ?>" id="<?php echo $register->id; ?>_checked" name="<?php echo $register->id; ?>_checked">
                  
                  <input title="fixed costs" class="form-check-input" type="checkbox" class="chk_fixed_costs form-control" <?php echo ($register->fixed_costs == 1 ? 'checked="checked"' : ''); ?> value="<?php echo $register->fixed_costs; ?>" id="<?php echo $register->id; ?>_fixed_costs" name="<?php echo $register->id; ?>_fixed_costs">
                  
                  <input title="published" class="form-check-input" type="checkbox" class="chk_published form-control" <?php echo ($register->published == 1 ? 'checked="checked"' : ''); ?> value="<?php echo $register->published; ?>" id="<?php echo $register->id; ?>_published" name="<?php echo $register->id; ?>_published">

                </div>
            
            </div>

				@endforeach

        <input type="hidden" id="bag" name="bag" value="">

</form>

            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>

<script>
  $(function () {

    $('.chk_status').attr('title', 'status');
    $('.chk_checked').attr('title', 'checked');
    $('.chk_fixed_costs').attr('title', 'fixed costs');
    $('.chk1_published').attr('title', 'published');

    var verifyChk = function( ) {
      var i = 0;
      var _bag = '';
      var _virgula = ',';
      $('input:checkbox[id=chkbox]').each(function(){
        _virgula = ',';
        if ($(this).is(':checked')) {
          if (i == 0) _virgula = '';
          _bag += _virgula + $(this).val();
          i++;
        }
      });
      $('#bag').val(_bag);
    };

    $('.chkBX').on('change', function() {
      verifyChk();
    });

    $('#select_all_').on('change', function() {
      $('input:checkbox[id=chkbox]').not(this).prop('checked', this.checked);
      verifyChk();
    });

    $(".btnSubmit").click(function(ev) {            
        ev.preventDefault();
        var i = 0;
        $('input:checkbox[id=chkbox]').each(function(){
          if ($(this).is(':checked')) {
            i++;
          }
        });
        if (i > 0)  
          $("#fsupport").submit();
        else
          alert('Please check at least an entry to save! Thanks!');
    });

  });
</script>

@endsection