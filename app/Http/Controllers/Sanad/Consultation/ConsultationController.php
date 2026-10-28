<?php

namespace App\Http\Controllers\Sanad\Consultation;

use App\Http\Controllers\Controller;
use App\Services\Sanad\ConsultationRequestService as ObjService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Sanad\ConsultationRequest;

class ConsultationController extends Controller
{
    public string $folderPath = 'sanad.consultation';

    public string $mainRoute = 'consultation-requests';

    /**
     * @throws \Exception
     */
    public function index(Request $request, ObjService $service): mixed
    {
        if ($request->ajax()) {
            $data = $service->getDataTable();

            if ($request->filled('is_read')) {
                $data->where('is_read', (bool) $request->is_read);
            }

            if ($request->filled('date_from')) {
                $data->whereDate('created_at', '>=', $request->date_from);
            }

            if ($request->filled('date_to')) {
                $data->whereDate('created_at', '<=', $request->date_to);
            }

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('is_read', function ($row) {
                    $btnClass = $row->is_read ? 'btn-success' : 'btn-danger';
                    $label = $row->is_read ? __('auth.read') : __('auth.unread');
                    if (checkIfHasPermission('consultation-requests-read')) {
                        return '<button type="button" class="btn btn-sm '.$btnClass.' toggle-read-btn" data-id="'.$row->id.'" data-status="'.($row->is_read ? '1' : '0').'">'.$label.'</button>';
                    }

                    return $row->is_read
                        ? '<span class="badge bg-success">'.e(__('auth.read')).'</span>'
                        : '<span class="badge bg-danger">'.e(__('auth.unread')).'</span>';
                })
                ->addColumn('mobile_whatsapp', function ($row) {
                    $phone = $row->mobile_whatsapp;
                    // Filter to Egyptian or Saudi numbers only
                    $clean = preg_replace('/[^0-9+]/', '', $phone);
                    if (preg_match('/^(0020|20|\+20|0)?1[0-9]{9}$/', $clean) || preg_match('/^(0020|20|\+20)/', $clean) && preg_match('/^20[0-9]{9,11}$/', preg_replace('/\D/', '', $clean))) {
                        // Egyptian format
                    } elseif (preg_match('/^(00966|966|\+966|0)?5[0-9]{8}$/', $clean) || preg_match('/^9665[0-9]{8}$/', preg_replace('/\D/', '', $clean))) {
                        // Saudi format
                    } else {
                        // Try to normalize
                        $num = preg_replace('/\D/', '', $clean);
                        if (strlen($num) == 10 && $num[0] == '1') {
                            // assume Egyptian
                        } elseif (strlen($num) == 9 && $num[0] == '5') {
                            // assume Saudi
                        } elseif (strlen($num) == 12 && substr($num, 0, 2) == '20') {
                        } elseif (strlen($num) == 12 && substr($num, 0, 3) == '966') {
                        } else {
                            return '<span class="text-muted" title="'.e($phone).'">'.e($phone).'</span>';
                        }
                    }

                    return '<a href="https://wa.me/'.preg_replace('/\D/', '', $phone).'" target="_blank" rel="noopener">'.e($phone).'</a>';
                })
                ->addColumn('actions', function ($row) {
                    $viewBtn = checkIfHasPermission('consultation-requests-read')
                        ? '<button type="button" class="btn btn-sm btn-primary me-1" onclick="showConsultation('.$row->id.')"><i class="ti ti-eye"></i></button>'
                        : '';
                    $deleteBtn = checkIfHasPermission('consultation-requests-delete')
                        ? deleteButton(route($this->mainRoute.'.destroy', $row->id))
                        : '';

                    return $viewBtn.' '.$deleteBtn;
                })
                ->addColumn('created_at', fn ($row) => $row->created_at?->format('Y-m-d H:i'))
                ->escapeColumns([])
                ->make(true);
        }

        $data['bladeTitle'] = __('auth.consultation_requests');
        $data['dataTableRoute'] = route($this->mainRoute.'.index');

        return view($this->folderPath.'.index', $data);
    }

    public function show(int $id, ObjService $service): JsonResponse
    {
        $obj = $service->find($id);
        if (! $obj->is_read) {
            $obj->update(['is_read' => true]);
        }

        $html = view($this->folderPath.'.show', compact('obj'))->render();

        return jsonSuccess(['html' => $html]);
    }

    public function destroy(int $id, ObjService $service): JsonResponse
    {
        $service->delete($id);

        return jsonSuccess();
    }

    public function toggleRead(Request $request, int $id): JsonResponse
    {
        $obj = ConsultationRequest::findOrFail($id);
        $obj->is_read = ! $obj->is_read;
        $obj->save();

        $unread = ConsultationRequest::where('is_read', false)->count();

        return response()->json([
            'code' => 200,
            'is_read' => $obj->is_read,
            'unread_count' => $unread,
        ]);
    }
}
