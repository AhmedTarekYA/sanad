@extends('crm.layout')

@section('page-title', $pageTitle)

@section('content')
    <div class="card shadow-sm border-0">
        <div class="card-header">
            <h5 class="mb-0">{{ __('edit') }} · {{ __('crm_sales') }}</h5>
        </div>
        <div class="card-body">
            @include('crm.sales._form', [
                'action' => route('crm.crm_sales.update', ['id' => $sale->id]),
                'method' => 'PUT',
                'sale' => $sale,
            ])
        </div>
    </div>
@endsection

@section('js')
    @include('crm.sales._script')
@endsection
