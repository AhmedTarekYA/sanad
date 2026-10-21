<div class="col-12">
    <div class="work_samples_grid">
        <label class="img_upload">
            <input type="file" accept="image/*" multiple name="image[]"
                id="img-upload" onchange="handleFileSelect(event)">
            <div class="img justify-content-center">
                <img loading="lazy" src="{{asset("admin")}}/assets/img/plus.svg" alt="plus">
            </div>
        </label>
        @if ($obj->images->count() > 0)
            @foreach ($obj->images as $image)
                <div class="uploadedImage">
                    <img src="{{ showFile($image->image) }}" alt="">
                    <button type="button" style="border: none;background: none;color:red" class="delete deleteImagesButton"
                        delete-route="{{ route('works-images.destroy', $image->id) }}">
                        <img loading="lazy" src="{{ asset('admin') }}/assets/img/trash.svg" alt="trash">
                    </button>
                </div>
            @endforeach
        @endif
    </div>
</div>
