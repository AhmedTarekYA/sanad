@extends('crm.layout')

@section('page-title', $pageTitle)

@section('content')
    <div class="card">
        <div class="card-body">
            <h4 class="mb-2">{{ __('auth.welcomeback') }}</h4>
            <p class="text-muted mb-0">{{ auth('crm')->user()?->name }}</p>
        </div>
    </div>
    @include('crm.partials.help-modal', [
        'title' => __('crm_help_dashboard_title'),
        'description' => __('crm_help_dashboard_desc'),
    ])
@endsection
