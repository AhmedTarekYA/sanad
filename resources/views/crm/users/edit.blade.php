@extends('crm.layout')

@section('page-title', $pageTitle)

@section('content')
    <div class="card shadow-sm border-0">
        <div class="card-header">
            <h5 class="mb-0">{{ __('edit') }} · {{ __('users') }}</h5>
        </div>
        <div class="card-body">
            @include('crm.users._form', [
                'action' => route('crm.users.update', ['id' => $user->id]),
                'method' => 'PUT',
                'user' => $user,
            ])
        </div>
    </div>
@endsection

@section('js')
    @include('crm.users._script')
@endsection
