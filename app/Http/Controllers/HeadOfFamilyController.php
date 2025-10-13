<?php

namespace App\Http\Controllers;

use App\Models\HeadOfFamily;
use App\Repositories\HeadOfFamilyRepository;
use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;
use App\Http\Resources\HeadOfFamilyResource;
use App\Http\Resources\PaginateResource;
use App\Http\Requests\HeadOfFamilyStoreRequest;
use App\Http\Requests\HeadOfFamilyUpdateRequest;

class HeadOfFamilyController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    private HeadOfFamilyRepository $headOfFamilyRepository;
    public function __construct(HeadOfFamilyRepository $headOfFamilyRepository)
    {
        $this->headOfFamilyRepository = $headOfFamilyRepository;
    }

    public function index(Request $request)
    {
        try {
            $headOfFamilies = $this->headOfFamilyRepository->getAll(
                $request->search,
                $request->limit,
                true
            );
            return ResponseHelper::jsonResponse(true, 'Data Keluarga Berhasil Diambil', HeadOfFamilyResource::collection($headOfFamilies), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, 'Data Keluarga Gagal Diambil', null, 500);
        }
    }

    public function getAllPaginated(Request $request)
    {
        $request = $request->validate([
            'search' => 'nullable|string',
            'rowPerPage' => 'required|integer',
        ]);

        try {
            $headOfFamilies = $this->headOfFamilyRepository->getAllPaginated(
                $request['search'] ?? null,
                $request['rowPerPage']
            );

            return ResponseHelper::jsonResponse(true, 'Data Keluarga Berhasil Diambil', PaginateResource::make($headOfFamilies, HeadOfFamilyResource::class), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, 'Data Keluarga Gagal Diambil', null, 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(HeadOfFamilyStoreRequest $request)
    {
        $request = $request->validated();
        try {
            $headOfFamily = $this->headOfFamilyRepository->create($request);
            return ResponseHelper::jsonResponse(true, 'Data Keapala Keluarga Berhasil Ditambahkan', new HeadOfFamilyResource($headOfFamily), 201);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, 'Data Keluarga Gagal Ditambahkan', null, 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $headOfFamily = $this->headOfFamilyRepository->getById($id);
            if (!$headOfFamily) {
                return ResponseHelper::jsonResponse(false, 'kepala keluarga tidak ditemukan', null, 404);
            }
            return ResponseHelper::jsonResponse(true, 'Detail kepala keluarga Berhasil Diambil', new HeadOfFamilyResource($headOfFamily), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(HeadOfFamilyUpdateRequest $request, string $id)
    {
        $request = $request->validated();
        try {
            $headOfFamily = $this->headOfFamilyRepository->getById($id);

            if (!$headOfFamily) {
                return ResponseHelper::jsonResponse(false, 'kepala keluarga tidak ditemukan', null, 404);
            }

            $headOfFamily = $this->headOfFamilyRepository->update($id, $request);


            return ResponseHelper::jsonResponse(true, 'Data Kepala Keluarga Berhasil Di Update', new HeadOfFamilyResource($headOfFamily), 201);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, 'Data Kepala Keluarga gagal di Update', null, 500);
        }
    }

    public function destroy(string $id)
    {
        try {
            $headOfFamily = $this->headOfFamilyRepository->getById($id);
            if (!$headOfFamily) {
                return ResponseHelper::jsonResponse(false, 'Kepala keluarga tidak ditemukan', null, 404);
            }

            $this->headOfFamilyRepository->delete($id);
            return ResponseHelper::jsonResponse(true, 'Kepala keluarga berhasil dihapus', null, 200);
            
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }
}
