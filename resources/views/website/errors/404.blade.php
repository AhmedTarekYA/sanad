@extends('website.layouts.app')

@section('page_key', '404.html')
@section('title', 'الصفحة غير موجودة (404) — SANAD CX')

@section('content')
<h1>الصفحة غير موجودة (404)</h1> <p>العنوان المطلوب غير متاح على هذا الموقع.</p> <p><a class="sanad-btn" href="{{ route('website.home') }}">العودة إلى الرئيسية</a></p>
@endsection
