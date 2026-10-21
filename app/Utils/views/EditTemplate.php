<?php

namespace App\Utils\views;

class EditTemplate
{
    public const TEMPLATE_CONTENT = <<<HTML
<form class="row g-3 from-submit-global" method="post" action="{{ \$updateRoute }}" enctype="multipart/form-data">
    @csrf
    @method('put')
    <!-- Add your form fields here -->

    <div class="col-12 modal-footer">
        {!! updateButton( \$updateRoute ) !!}
        {!! closeButton() !!}
    </div>
</form>
HTML;
}
