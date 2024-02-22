<form role="form" id="formWizard" class="form--wizard" enctype="multipart/form-data" method="post" action="{{url('home-heading')}}">
    {{csrf_field()}}
    <div class="card-body">
        <div class="form-row">
            <div class="form-group col-md-12">
                <label for="home_title">Title*</label>
                <input type="text" class="form-control required" id="home_title" name="homeTitle"
                       placeholder="Title" value="{{@$home_heading->title}}">
                <div class="help-block with-errors" id="home_title_error"></div>
                @error('home_title')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-12">
                <label for="subtitle">Sub Title*</label>
                <input type="text" class="form-control required" id="subtitle" name="subtitle"
                       placeholder="Sub Title" value="{{@$home_heading->subtitle}}">
                <div class="help-block with-errors" id="subtitle_error"></div>

            </div>
        </div>


        <input type="hidden" name="is_description" id="is_description" value="1">
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="home_description">Description</label>
                    <textarea class="form-control tinyeditor" id="home_description" name="homeDescription"
                              placeholder="Description">{{@$home_heading->description}}</textarea>
                    <div class="help-block with-errors" id="home_description_error"></div>
                    @error('home_description')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

    </div>
    <div class="card-footer">
        <input type="submit" id="headingSubmit" data-type="selection"
               name="btn_save" data-url="/home-heading" value="Submit" class="btn btn-primary pull-left submitBtn">
        <button type="reset" class="btn btn-default">Cancel</button>
        <img class="animation__shake loadingImg" src="{{asset('backend/dist/img/loading.gif')}}"
             style="display:none;">
    </div>
</form>