
<div class="modal fade" data-bs-backdrop="static" id="createModal" tabindex="-1" aria-labelledby="exampleModalLgLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-scrollable {{(isset($modalType))? $modalType:"modal-xl"}}">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title h4" id="exampleModalLgLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body custom_scroll"></div>
            {{--<div class="modal-footer">
               --}}{{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__("buttons.close")}}</button>
                <button type="button" class="btn btn-primary">{{__("buttons.save")}}</button>--}}{{--
            </div>--}}
        </div>
    </div>
</div>


<div class="modal fade" data-bs-backdrop="static" id="upCreateModal" tabindex="-1" aria-labelledby="exampleModalLgLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-scrollable {{(isset($modalType))? $modalType:"modal-xl"}}">
        <div class="modal-content" style="height: auto;">
            <div class="modal-header">
                <h5 class="modal-title h4" id="exampleModalLgLabel"></h5>
                <input type="hidden" name="popup_id" id="popup_id" value="">
                <input type="hidden" name="up_id" id="item_add_id" value="">
                <input type="hidden" name="up_name_id" id="item_add_name_id" value="">
                <button type="button" class="btn-close upCreateModalClose" ></button>
            </div>
            <div class="modal-body custom_scroll"></div>
            {{--<div class="modal-footer">
               --}}{{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__("buttons.close")}}</button>
                <button type="button" class="btn btn-primary">{{__("buttons.save")}}</button>--}}{{--
            </div>--}}
        </div>
    </div>
</div>


 <!-- Modal for Image Cropping -->
 {{-- <div class="modal fade" id="cropImageModal" tabindex="-1" aria-labelledby="cropImageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cropImageModalLabel">{{ __("auth.crop_image") }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="img-container">
                    <img id="cropperImage" class="image-preview" src="">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __("auth.Cancel") }}</button>
                <button type="button" id="cropImageBtn" class="btn btn-primary">{{ __("auth.crop_save") }}</button>
            </div>
        </div>
    </div>
</div> --}}
