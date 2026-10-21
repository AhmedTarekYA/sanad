<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\ConfigRequest;
use App\Services\Config\ConfigService;
use Illuminate\Http\Request;

class ConfigController extends Controller
{
    public function configByName(ConfigRequest $request, ConfigService $objService)
    {
        $data = $request->validated();

        $config = $objService->getDataByName($data);
        if (!$config) {
            // return jsonSuccess(null, 'Config not found', 404);
            return response()->json([
                'code' => 404,
                'data' => null,
                'message' => 'Config not found'
            ], 404);
        }

        $data = $objService->formatConfig($config);

        return jsonSuccess($data);
    }
}
