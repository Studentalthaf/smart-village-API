<?php

namespace App\Repositories;
use App\Interfaces\FamilyMemberRepositoryInterface;

use App\Models\FamilyMember;
use App\Helpers\ResponseHelper;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Arr;
use App\Repositories\UserRepository;



class FamilyMemberRepository implements FamilyMemberRepositoryInterface
{
    public function getAll(?string $search, ?int $limit, bool $execute)
    {
        $query = FamilyMember::where(function ($query) use ($search) {

            if ($search) {
                $query->search($search);
            }
        });

        if ($limit) {
            $query->limit($limit);
        }
        if ($execute) {
            return $query->get();
        }
        return $query;
    }
    public function getAllPaginated(?string $search, int $rowPerPage)
    {
        $query = $this->getAll($search, $rowPerPage, false);

        return $query->paginate($rowPerPage);
    }
    public function getById(string $id)
    {
        try {
            return FamilyMember::with('headOfFamily')->findOrFail($id);
        } catch (\Exception $e) {
            return null;
        }
    }
    public function create(array $data)
    {
        DB::beginTransaction();
        try {
            Log::info('Starting create family member with data:', Arr::except($data, ['password']));
            
            $userRepository = new UserRepository();
            $user = $userRepository->create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $data['password'],
            ]);
            $familyMember = new FamilyMember();
            $familyMember->head_of_family_id = $data['head_of_family_id'];
            $familyMember->user_id = $user->id;
            $familyMember->profile_picture = $data['profile_picture']->store('assets/family-member', 'public');
            $familyMember->identity_number = $data['identity_number'];
            $familyMember->gender = $data['gender'];
            $familyMember->date_of_birth = $data['date_of_birth'];
            $familyMember->phone_number = $data['phone_number'];
            $familyMember->occupation = $data['occupation'];
            $familyMember->marital_status = $data['marital_status'];
            $familyMember->relation = $data['relation'];
            $familyMember->save();
            DB::commit();
            return $familyMember;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }
}