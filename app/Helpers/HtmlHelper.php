<?php

if (!function_exists('addButton')) {
    function addButton($route, $text = "")
    {
        if(checkIfHasPermission(getRouteNameFromRoute($route) . '-create')){
            $fullText = __("buttons.add button") . ' ' . $text;
            return '
                    <div class="d-flex mb-3 justify-content-end">
                        <button type="button" class="btn btn-success float-start addButton mx-1" data-bs-toggle="modal" data-bs-target="#createModal"
                               model-title="' . $fullText . '"  model-route="' . $route . '" title="' . __("buttons.add button") . '" >
                           <i class="fa fa-plus-circle"></i>  ' . $fullText . '
                        </button>
                    </div>
                    ';
        }
        return '';
    }
}

/**
 * @param $route
 * @param $text
 * @return string
 */

if (!function_exists('createButton')) {
    function createButton($route, $text = "")
    {
        if(checkIfHasPermission(getRouteNameFromRoute($route) . '-create')){
            $fullText = __("buttons.add button") . ' ' . $text;
            return '
                    <div class="d-flex mb-3 justify-content-end">
                        <a htef="' . $route . '">
                            <button type="button" class="btn btn-success float-start mx-1"  title="' . __("buttons.add button") . '" >
                            <i class="fa fa-plus-circle"></i>  ' . $fullText . '
                            </button>
                        </a>
                    </div>
                    ';
        }
        return '';
    }
}

if (!function_exists('addUpButton')) {
    function addUpButton($route, $item_id = "", $text = "", $item_name_id = "", $notup_popup = false)
    {
        $fullText = ($text === false) ? "" : __("buttons.add button") . ' ' . $text;

        return ' <i class="fa fa-plus-circle addUpButton fastCreate" data-bs-toggle="modal" data-bs-target="#upCreateModal"
                          item-id="' . $item_id . '" item-name-id="' . $item_name_id . '" item-popup-id="' . $notup_popup . '"
                          model-title="' . $fullText . '"  model-route="' . $route . '"
                          title="' . __("buttons.add button") . '" ></i> ';
    }
}

/**
 * @param $route
 * @param $text
 * @return string
 */
if (!function_exists('editButton')) {
    function editButton($route, $text = "", $icon='pencil', $color='primary')
    {
        if(checkIfHasPermission(getRouteNameFromRoute($route) . '-update')){
            $fullText = __("buttons.edit") . ' ' . $text;
            return '<button type="button" class="btn btn-' . $color . ' editButton" data-bs-toggle="modal" data-bs-target="#createModal"
                        model-route="' . $route . '" model-title="' . $fullText . '">
                    <i class="ti ti-edit" aria-hidden="true"></i>
                    </button>';
        }
        return '';
    }
}

if (!function_exists('addOfferButton')) {
    function addOfferButton($route, $text = "", $icon='pencil', $color='primary')
    {
        if(checkIfHasPermission(getRouteNameFromRoute($route) . '-update')){
            $fullText = __("buttons.addOffer") . ' ' . $text;
            return '<button type="button" class="btn btn-' . $color . ' editButton" data-bs-toggle="modal" data-bs-target="#createModal"
                        model-route="' . $route . '" model-title="' . $fullText . '">
                    <i class="fa fa-' . $icon . '"></i>
                    </button>';
        }
        return '';
    }
}

if (!function_exists('showButton')) {
    function showButton($route, $text = "", $icon = 'eye', $color = 'warning')
    {
        if(checkIfHasPermission(getRouteNameFromRoute($route) . '-read')){
            $fullText = __("buttons.show") . ' ' . $text;
            return '<button type="button" class="btn btn-' . $color . ' editButton" data-bs-toggle="modal" data-bs-target="#createModal"
                        model-route="' . $route . '" model-title="' . $fullText . '">
                        <i class="fa fa-' . $icon . '"></i>
                    </button>';
        }
        return '';
    }
}

if (!function_exists('customButton')) {
    function customButton($route,  $text = "", $color = 'primary', $icon = 'pencil', $type = 'addButton', $count = null)
    {
        if(checkIfHasPermission(getRouteNameFromRoute($route) . '-create')){
            $count = $count == 0 || is_null($count) ? '' : '<span class="bg-danger text-white rounded px-1">' . $count . '</span>';
            return '<button type="button" class="btn btn-' . $color . ' ' . $type . '" data-bs-toggle="modal" data-bs-target="#createModal"
                        model-route="' . $route . '" model-title="' . $text . '">
                        <i class="fa fa-' . $icon . '"></i> '. $count .'
                    </button>';
        }
        return '';
    }
}

if (!function_exists('verificationButton')) {
    function verificationButton($route,  $text = "", $color = 'primary', $icon = 'pencil', $type = 'addButton')
    {
        if(checkIfHasPermission(getRouteNameFromRoute($route) . '-create')){
            return '<button type="button" class="btn btn-' . $color . ' ' . $type . '" data-bs-toggle="modal" data-bs-target="#createModal"
                        model-route="' . $route . '" model-title="">
                        <i class="fa fa-' . $icon . '"></i> '. $text .'
                    </button>';
        }
        return '';
    }
}
if (!function_exists('addPlus')) {
    function addPlus($route, $text = "")
    {

        return '
    <button type="button"
            class="btn btn-success addButton mx-1"
            data-bs-toggle="modal"
            data-bs-target="#createModal"
            model-route="' . $route . '"
            model-title="' . $text . '">
        <i class="fa fa-plus me-2"></i>
        '.$text.'
    </button>
    ';
    }
}
/**
 * @param $route
 * @param $text
 * @return string
 */
if (!function_exists('editButtonLink')) {
    function editButtonLink($route, $text = "")
    {
        $fullText = __("buttons.edit") . ' ' . $text;
        return '<a href="' . $route . '">
                    <button type="button" class="btn btn-primary">
                       <i class="ti ti-edit" aria-hidden="true"></i>
                    </button>
                </a>';
    }
}

/**
 * @param $route
 * @return string
 */
if (!function_exists('deleteButton')) {
    function deleteButton($route, $color = 'danger', $icon = 'trash-o')
    {
        if(checkIfHasPermission(getRouteNameFromRoute($route) . '-delete')){
            return '<button type="button" class="btn btn-' . $color . ' deleteButton" delete-route="' . $route . '">
                      <i class="ti ti-trash" aria-hidden="true"></i>
                </button>';
        }
        return '';
    }
}

if (!function_exists('deleteFile')) {
    function deleteFile($path, $isFolder = false)
    {
        // Combine the full path
        $fullPath = storage_path(\App\Helpers\ConstantHelper::filesPath . $path);

        // Check if it is a folder or a file
        if ($isFolder) {
            return File::exists($fullPath) ? File::deleteDirectory($fullPath) : false;
        }

        return File::exists($fullPath) ? File::delete($fullPath) : false;
    }
}

if (!function_exists('cusstomConfirmButton')) {
    function cusstomConfirmButton($route, $color = 'success', $icon = 'check',$method = "GET", $text= '')
    {
        if(checkIfHasPermission(getRouteNameFromRoute($route) . '-update')){
        return '<button type="button" class="btn btn-' . $color . ' cusstomConfirmButton" confirm-route="' . $route . '">
                      <i class="fa fa-' . $icon . '"></i>  '. $text .'
                </button>';
        }
        return '';
    }
}

/**
 * @param $enumArr
 * @param $array_name
 * @param $optionSelect
 * @return string
 */

// if (!function_exists('getEnumData')) {
//     function getEnumData($enumArr, $array_name, $optionSelect = '')
//     {
//         $options = '<option value="">' . helperTrans('ingaz.choose') . '</option>';
//         $constantArray = \App\Helpers\ConstantHelper::globalArray[$array_name];
//         $locale = \App::currentLocale();
//         foreach ($enumArr as $case) {
//             $text = (isset($constantArray[$case->value][$locale])) ? $constantArray[$case->value][$locale] : "undefined";
//             $selected = ($optionSelect == $case->value) ? "selected" : "";
//             $options .= '<option value="' . $case->value . '"  ' . $selected . '>' . $text . '</option>';
//         }
//         return $options;
//     }
// }

if (!function_exists('getEnumData')) {
    function getEnumData($enumArr, $optionSelect = '')
    {
        $options = '<option value="">' . helperTrans('auth.choose') . '</option>';
        $locale = \App::currentLocale();
        foreach ($enumArr as $case) {
            $selected = ($optionSelect == $case->value) ? "selected" : "";
            $options .= '<option value="' . $case->value . '"  ' . $selected . '>' . $case->lang() . '</option>';
        }
        return $options;
    }
}


/**
 * @param $array_name
 * @param $key
 * @return mixed|string
 */

if (!function_exists('getEnumValue')) {
    function getEnumValue($array_name, $key)
    {
        $constantArray = \App\Helpers\ConstantHelper::globalArray[$array_name];
        $locale = \App::currentLocale();
        return (isset($constantArray[$key][$locale])) ? $constantArray[$key][$locale] : "undefined";
    }
}

/**
 * @param $array
 * @param $key_name
 * @param $optionSelect
 * @param $attr
 * @return string
 */
if (!function_exists('showSelectElement')) {

    function showSelectElement($array, $key_name, $optionSelect = '', $attr = "")
    {
        $options = '<option value="">اختر </option>';
        if ($array != null && !empty($array) && count($array) > 0) {
            foreach ($array as $one) {
                $text = $one->{$key_name};
                $value = $one->id;
                $selected = ($optionSelect == $value) ? "selected" : "";
                $options .= '<option value="' . $value . '"  ' . $attr . '  ' . $selected . '>' . $text . '</option>';
            }
        } else {
            $options = '<option value="">لا يوجد بيانات </option>';
        }

        return $options;
    }
}

/**
 * @param $route
 * @return string
 */
// {!! submitButton() !!}
if (!function_exists('submitButton')) {
    function submitButton($route = "", $text = "", $color = 'primary')
    {
        $fullText = ($text != "") ? $text : __("buttons.save");
        return '<button class="btn btn-' . $color . ' mySubmitButton" type="submit">' . $fullText . '</button>';
    }
}

if (!function_exists('storeButton')) {
    function storeButton($route = "", $text = "", $color = 'primary')
    {
        if(checkIfHasPermission(getRouteNameFromRoute($route) . '-create')){
            $fullText = ($text != "") ? $text : __("buttons.save");
            return '<button class="btn btn-' . $color . ' mySubmitButton" type="submit">' . $fullText . '</button>';
        }
        return '';
    }
}

if (!function_exists('updateButton')) {
    function updateButton($route = "", $text = "", $color = 'primary')
    {
        if(checkIfHasPermission(getRouteNameFromRoute($route) . '-update')){
            $fullText = ($text != "") ? $text : __("buttons.save");
            return '<button class="btn btn-' . $color . ' mySubmitButton" type="submit">' . $fullText . '</button>';
        }
        return '';
    }
}

// {!! closeButton() !!}
if (!function_exists('closeButton')) {
    function closeButton($class = "", $text = "")
    {
        $fullText = ($text != "") ? $text : __("buttons.close");
        return '<button class="btn btn-outline-secondary upCreateModalClose ' . $class . '" type="button" data-bs-dismiss="modal">' . $fullText . '</button>';
    }
}

if(!function_exists('dropdownButtons')){
    function dropdownButtons($buttons = [])
    {
        $html = '<div class="dropdown">
            <button class="btn btn-outline-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa fa-ellipsis-h"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-dark border-0 shadow p-3">';

        foreach ($buttons as $name => $button) {
            if ($button == null || $button == "") {
                continue;
            }
            $html .= '<li class="mb-1 d-flex align-items-center" style="padding: 5px 10px;">
                        <div class="d-flex justify-content-between align-items-center w-100">
                            <span class="me-2 text-white" style="flex-grow: 1; font-size: 14px; line-height: 1.5;">' . htmlspecialchars(__('buttons.' . $name . '')) . '</span>
                            <div style="flex-shrink: 0;">' . $button . '</div>
                        </div>
                    </li>';
        }

        $html .= '</ul></div>';

        return $html;

    }
}
