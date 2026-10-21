<form class="row g-3 from-submit-global" method="post" action="{{ $storeRoute }}" enctype="multipart/form-data">

    <div class="col-12">
        <label for="TextInput" class="form-label">{{ __("permission.name") }}</label>
        <input type="text" name="name" class="form-control" data-validation="required">
    </div>
    <div class="col-12">
        <label for="TextInput" class="form-label">{{ __("permission.display_name") }}</label>
        <input type="text" name="display_name" class="form-control" data-validation="required">
    </div>
    <div class="col-12">
        <label for="TextInput" class="form-label">{{ __("permission.description") }}</label>
        <input type="text" name="description" class="form-control" data-validation="required">
    </div>
    <div class="col-12">
        <label for="TextInput" class="form-label">{{ __("permission.description_ar") }}</label>
        <input type="text" name="description_ar" class="form-control" data-validation="required">
    </div>

    <div class="col-12 modal-footer">
        <button class="btn btn-primary" type="submit">{{__("buttons.save")}}</button>
        <button class="btn btn-outline-secondary" type="button" data-bs-dismiss="modal">{{__("buttons.close")}}</button>
    </div>

</form>
