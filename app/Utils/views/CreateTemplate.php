<?php

namespace App\Utils\views;

class CreateTemplate
{
    public const TEMPLATE_CONTENT = <<<HTML
<form class="row g-3 from-submit-global" method="post" action="{{ \$storeRoute }}" enctype="multipart/form-data">
    @csrf
    <!-- Add your form fields here -->

    <div class="col-12 modal-footer">
        {!! storeButton( \$storeRoute ) !!}
        {!! closeButton() !!}
    </div>
</form>
HTML;
}
