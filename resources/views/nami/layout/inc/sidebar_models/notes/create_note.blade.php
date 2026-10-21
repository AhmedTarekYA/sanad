<form class="from-submit-global" method="post" action="{{ route('notes.store') }}" enctype="multipart/form-data">
    <div class="form-floating mb-2">
        <input type="text" name="title" class="form-control" placeholder="Note Title" data-validation="required">
        <label>العنوان</label>
    </div>
    <div class="form-floating mb-2">
        <input type="date" name="date" class="form-control datepicker" placeholder="Select Date"
            data-validation="required">
        <label> التاريخ</label>
    </div>
    <div class="form-floating mb-2">
        <select class="form-select" id="floatingSelect" name="type" aria-label="Floating label select example"
            data-validation="required">
            
            {!! getEnumData($note_types, 'note_types') !!}

        </select>
        <label>النوع</label>
    </div>
    <div class="form-floating mb-2">
        <select class="form-control show-tick ms select2" name="user_ids[]" multiple data-placeholder="Select"
            data-validation="required">
            {!! showSelectElement($users, 'name') !!}
        </select>
        <label>المستخدم</label>
    </div>
    <div class="form-floating mb-4">
        <textarea class="form-control" name="note" placeholder="Leave a comment here" style="height: 100px"></textarea>
        <label>ملاحظة</label>
    </div>

    <button type="submit" class="btn btn-primary lift">{{ __('buttons.save') }}</button>
    <button class="btn btn-outline-secondary" type="button" data-bs-dismiss="modal">{{ __('buttons.close') }}</button>
</form>
