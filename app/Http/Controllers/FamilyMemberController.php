<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\FamilyMemberRepositoryInterface;
use app\Helpers\ResponseHelper;
use App\Http\Resources\FamilyMemberResource;
use App\Http\Resources\PaginateResource;

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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
