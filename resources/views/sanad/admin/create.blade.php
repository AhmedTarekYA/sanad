<form class="row g-3 from-submit-global" method="post" action="{{ $storeRoute }}" enctype="multipart/form-data">
    <div class="col-6">
        <label for="TextInput" class="form-label">الاسم </label>
        <input type="text" name="name" class="form-control" data-validation="required">
    </div>
    <div class="col-6">
        <label for="TextInput" class="form-label">الجوال </label>
        <input type="tel" name="phone" class="form-control" placeholder="01012345678" inputmode="tel" data-validation="required">
    </div>

    <div class="col-6">
        <label for="TextInput" class="form-label">البريد الالكترونى </label>
        <input type="text" name="email" class="form-control">
    </div>
    <div class="col-6">
        <label for="TextInput" class="form-label"> كلمة المرور </label>
    <input type="password" name="password" placeholder="" class="form-control">
    </div>

    {{-- <div class="col-4">
        <label for="TextInput" class="form-label"> نوع المستخدم </label>
        <select class="form-control show-tick ms" name="admin_type" id="admin_type"
                data-validation="required">
                {!! getEnumData($admin_typeis , "admin_typeis") !!}
        </select>
    </div> --}}

    <div class="row">
        <div class="col-12">
            <label for="TextInput" class="form-label mt-3"> {{ __('permission.roles') }} </label>
            <select name="role_id" class="form-control" data-validation="required">
                <option value="">{{__('permission.choose')}}</option>
                @foreach($roles as $role)
                    <option value="{{ $role->id }}">{{ $role->display_name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-12">
        <label for="image" class="form-label">{{ __("image") }}</label>
        <input type="file" id="image" name="image" class="dropify" data-validation="required">
    </div>


    <div class="col-12 modal-footer">
        <button class="btn btn-primary" type="submit">{{__("buttons.save")}}</button>
        <button class="btn btn-outline-secondary" type="button" data-bs-dismiss="modal">{{__("buttons.close")}}</button>
    </div>

</form>
