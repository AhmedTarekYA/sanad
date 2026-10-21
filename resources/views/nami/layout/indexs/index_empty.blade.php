<!DOCTYPE html>
<html lang="en">
<head>

    @include("admin.layout.inc._meta")
    <title>@yield('page-title')</title>


    @include("admin.layout.inc._css")

    @yield("style")


</head>
<body class="layout-1  rtl_mode " data-luno="theme-blue">

@include("admin.layout.inc.sidebar")


<div class="wrapper">

    @include("admin.layout.inc.header")

    {{-- @include("admin.layout.inc.top_menu")--}}

    @yield('content')

    @include("admin.layout.inc.footer")
</div>
@include("admin.layout.inc.global_modals")
@include("admin.layout.inc.siderbar_models")


@include("admin.layout.inc._js")
@include("admin.layout.inc._js_custom")


@yield("js")
</body>
</html>
