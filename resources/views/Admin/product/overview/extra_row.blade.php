<div class="form-row" id="append_result_{{$primary_key}}">
    <div class="form-group col-md-10">
        <label for="inputPassword4">Title</label>
        <input type="text" class="form-control" maxlength="180" name="extra_key[]" id="extra_key_{{$primary_key}}" placeholder="Key"
               maxlength="230">
        @error('extra_key')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group col-md-2" style="margin-top: 10px">
        <a href="javascript:void(0);" class="btn btn-success mt-4 add_overview_row btn-sm add_{{$primary_key}}"
           id="{{$primary_key}}"><i class="fa fa-plus fa-lg"></i></a>
        <a href="javascript:void(0);" class="btn btn-danger mt-4 remove_overview_row btn-sm" id="{{$primary_key}}"
           ref="0"><i class="fa fa-times fa-lg"></i></a>
        <input type="hidden" name="detail_id[]" id="detail_id_{{$primary_key}}" value="0">
    </div>
</div>
