<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Http\Requests\CRM\CrmSaleRequest;
use App\Services\CRM\CrmSaleService;
use App\Services\CRM\CrmUsersService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CrmSalesController extends Controller
{
    public function index(Request $request, CrmSaleService $service, CrmUsersService $usersService): View|JsonResponse
    {
        if ($request->ajax() || $request->wantsJson()) {
            return jsonSuccess([
                'items' => $service->listSales($request->integer('crm_user_id') ?: null),
            ]);
        }

        return view('crm.sales.index', [
            'pageTitle' => __('crm_sales'),
            'users' => $usersService->listUsers(),
        ]);
    }

    public function create(): View
    {
        return view('crm.sales.create', [
            'pageTitle' => __('crm_sales'),
        ]);
    }

    public function store(CrmSaleRequest $request, CrmSaleService $service): JsonResponse
    {
        $sale = $service->storeForUser(Auth::guard('crm')->id(), $request->validated());

        return jsonSuccess([
            'sale' => $sale,
            'url' => route('crm.crm_sales.index'),
        ], null, 201);
    }

    public function edit(int $id, CrmSaleService $service): View
    {
        return view('crm.sales.edit', [
            'pageTitle' => __('crm_sales'),
            'sale' => $service->find($id),
        ]);
    }

    public function update(CrmSaleRequest $request, int $id, CrmSaleService $service): JsonResponse
    {
        $sale = $service->updateForUser($id, $request->validated());

        return jsonSuccess([
            'sale' => $sale,
            'url' => route('crm.crm_sales.index'),
        ]);
    }

    public function destroy(int $id, CrmSaleService $service): JsonResponse
    {
        abort_if($service->find($id) === null, 404);

        $service->delete($id);

        return jsonSuccess();
    }
}
