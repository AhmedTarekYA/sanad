<form class="row g-3 from-submit-update-global" method="post" action="{{ route('notes.update', $obj->id) }}"
    enctype="multipart/form-data">
    @method('PUT')
    <div class="col-6">
        <label for="TextInput" class="form-label">العنوان</label>
        <input type="text" name="title" class="form-control" data-validation="required"data-validation="required"
            value="{{ $obj->title }}">
    </div>
    <div class="col-6">
        <label for="TextInput" class="form-label">التاريخ </label>
        <input type="date" name="date" class="form-control" data-validation="required"
            value="{{ $obj->date }}">
    </div>
    <div class="col-6">
        <label class="form-label">النوع </label>
        <select class="form-control" name="type" data-validation="required">
            {!! getEnumData($note_types, 'note_types', $obj->type) !!}
        </select>
    </div>
    <div class="col-6">
        <label for="TextInput" class="form-label"> المستخدم</label>
        <select class="form-control show-tick ms select2" name="user_ids[]" multiple data-placeholder="Select">
            @foreach ($users as $user)
                <option value="{{ $user->id }}"{{ in_array($user->id, $old_users) ? 'selected' : '' }}>
                    {{ $user->name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-6">
        <label for="TextInput" class="form-label"> الملاحظة </label>
        <textarea type="text" name="note" class="form-control form-control-lg mb-1" id="bs_maxlength_textarea"
            rows="5">{{ old('note', $obj->note) }}
        </textarea>
    </div>
    <div class="col-12 modal-footer">
        <button class="btn btn-primary" type="submit">{{ __('buttons.save') }}</button>
        <button class="btn btn-outline-secondary" type="button"
            data-bs-dismiss="modal">{{ __('buttons.close') }}</button>
    </div>

</form>
