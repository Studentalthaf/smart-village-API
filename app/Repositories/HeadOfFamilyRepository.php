<?php

namespace App\Repositories;

use App\Interfaces\HeadOfFamilyRepositoryInterface;
use App\Models\HeadOfFamily;
use Illuminate\Support\Facades\DB;

class HeadOfFamilyRepository implements HeadOfFamilyRepositoryInterface
{
    public function getAll(
        ?string $search,
        ?int $limit,
        bool $execute,
    ) {
        $query = HeadOfFamily::where(function ($query) use ($search) {

            if ($search) {
                $query->search($search);
            }
        });

        $query->orderBy('created_at', 'desc');

        if ($limit) {
            $query->limit($limit);
        }
        if ($execute) {
            return $query->get();
        }
        return $query;
    }

    public function getAllpaginated(
        ?string $search,
        int $rowPerPage,
    ) {
        $query = $this->getAll($search, $rowPerPage, false);

        return $query->paginate($rowPerPage);
    }
    public function getById(
        string $id
    ) {
        try {
            return HeadOfFamily::with('user')->findOrFail($id);
        } catch (\Exception $e) {
            return null;
        }
    }
    public function create(
        array $data
    ) {
        DB::beginTransaction();
        try {
            $userRepository = new UserRepository();
            $user = $userRepository->create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $data['password'],
            ]);
            $headOfFamily = new HeadOfFamily;
            $headOfFamily->user_id = $user->id;
            $headOfFamily->profile_picture = $data['profile_picture']->store('assets/head-of-family', 'public');
            $headOfFamily->identity_number = $data['identity_number'];
            $headOfFamily->gender = $data['gender'];
            $headOfFamily->date_of_birth = $data['date_of_birth'];
            $headOfFamily->phone_number = $data['phone_number'];
            $headOfFamily->occupation = $data['occupation'];
            $headOfFamily->marital_status = $data['marital_status'];
            $headOfFamily->save();

            DB::commit();
            return $headOfFamily;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }
    public function update(
        string $id,
        array $data
    ) {
        DB::beginTransaction();
        try {
            $headOfFamily = HeadOfFamily::find($id);

            if (!$headOfFamily) {
                throw new \Exception('Kepala keluarga tidak ditemukan');
            }

            if(isset($data['profile_picture'])){
                $headOfFamily->profile_picture = $data['profile_picture']->store('assets/head-of-family', 'public');
            }

            $headOfFamily->identity_number = $data['identity_number'];
            $headOfFamily->gender = $data['gender'];
            $headOfFamily->date_of_birth = $data['date_of_birth'];
            $headOfFamily->phone_number = $data['phone_number'];
            $headOfFamily->occupation = $data['occupation'];
            $headOfFamily->marital_status = $data['marital_status'];
            $headOfFamily->save();



            $userRepository = new UserRepository();
            
            $userData = [
                'name' => $data['name'],
            ];
            
            // Hanya update email jika dikirim, tidak kosong dan berbeda dengan yang sekarang
            if (isset($data['email']) && !empty($data['email'])) {
                $user = $headOfFamily->user;
                // Hanya kirim email jika berbeda dengan yang ada sekarang
                if ($user && $user->email !== $data['email']) {
                    $userData['email'] = $data['email'];
                }
            }
            
            // Hanya update password jika ada
            if (isset($data['password']) && !empty($data['password'])) {
                $userData['password'] = $data['password']; // UserRepository akan handle bcrypt
            }
            
            $userRepository->update($headOfFamily->user_id, $userData);

            DB::commit();
            return $headOfFamily;


        } catch (\Exception $th) {
            DB::rollBack();
            throw new \Exception($th->getMessage());
        }
    }
    public function delete(
        string $id
    ) {
        DB::beginTransaction();
        try {
            $headOfFamily = HeadOfFamily::find($id);
            if (!$headOfFamily) {
                throw new \Exception('Kepala keluarga tidak ditemukan');
            }
            $headOfFamily->delete();

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }

};
