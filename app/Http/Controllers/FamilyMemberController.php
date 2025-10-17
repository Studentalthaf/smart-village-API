<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\FamilyMemberRepositoryInterface;
use App\Helpers\ResponseHelper;
use App\Http\Requests\FamilyMemberStoreRequest;
use App\Http\Resources\FamilyMemberResource;
use App\Http\Resources\PaginateResource;
use Illuminate\Support\Facades\Log;

class FamilyMemberController extends Controller
{
    private FamilyMemberRepositoryInterface $familyMemberRepository;

    public function __construct(FamilyMemberRepositoryInterface $familyMemberRepository) {
        $this->familyMemberRepository = $familyMemberRepository;
    }


    public function index(Request $request)
    {
        try {
            $familyMembers = $this->familyMemberRepository->getAll
            (
                $request->query('search'),
                $request->query('limit'),
                true,
            );

             // Cek jika data kosong
        if ($familyMembers->isEmpty()) {
            return ResponseHelper::jsonResponse(
                false,
                'Data Anggota Keluarga tidak ditemukan',
                [],  
                404 
            );
        }

            return ResponseHelper::jsonResponse(true,
            'Data Anggota Keluarga Berhasil diambil',
            FamilyMemberResource::collection($familyMembers),
            200);

        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);

        }
    }
    public function getAllPaginated(Request $request)
    {
        $request->validate([
            'search' => 'nullable|string',
            'rowPerPage' => 'required|integer|min:1',
        ]);

        try {
            $familyMembers = $this->familyMemberRepository->getAllPaginated(
                $request['search']??null,
                $request['rowPerPage']
            );

            return ResponseHelper::jsonResponse(
                true,
                'Data Anggota Keluarga Berhasil diambil', PaginateResource::make($familyMembers, FamilyMemberResource::class),
                200
            );

        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);

        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(FamilyMemberStoreRequest $request)
    {
        try {
            $validated = $request->validated();
            
            // Debug data yang diterima
            Log::info('Data yang diterima:', $validated);
            
            $familyMember = $this->familyMemberRepository->create($validated);
            return ResponseHelper::jsonResponse(true, 'Data Anggota Keluarga Berhasil Ditambahkan', new FamilyMemberResource($familyMember), 201);
        } catch (\Exception $e) {
            // Log error lengkap
            Log::error('Error creating family member: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return ResponseHelper::jsonResponse(false, 'Data Anggota Keluarga Gagal Ditambahkan: ' . $e->getMessage(), null, 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $familyMember = $this->familyMemberRepository->getById($id);
            if (!$familyMember) {
                return ResponseHelper::jsonResponse(false, 'Anggota keluarga tidak ditemukan', null, 404);
            }
            return ResponseHelper::jsonResponse(true, 'Detail anggota keluarga Berhasil Diambil', new FamilyMemberResource($familyMember), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
