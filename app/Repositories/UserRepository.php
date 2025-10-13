<?php

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserRepository implements UserRepositoryInterface
{
    public function getAll(
        ?string $search,
        ?int $limit,
        bool $execute,
    ) {
        $query = User::where(function ($query) use ($search) {

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

    public function getAllpaginated(
        ?string $search,
        int $rowPerPage,
    ) {
        $query = $this->getAll($search, $rowPerPage, false);

        return $query->paginate($rowPerPage);
    }

    public function getById(string $id)
    {
        $query = User::where('id', $id);
        return $query->first();
    }


    public function create(array $data)
    {
        DB::beginTransaction();
        try {
            $user = new User();
            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->password = bcrypt($data['password']);
            $user->save();
            DB::commit();
            return $user;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }

    public function update($id, array $data)
    {
        DB::beginTransaction();
        try {
            $user = User::find($id);
            $user->name = $data['name'];
            
            // Update email jika ada
            if (isset($data['email'])) {
                $user->email = $data['email'];
            }

            if (isset($data['password']) ) {
                $user->password = bcrypt($data['password']);
            }
            $user->save();

            DB::commit();

            return $user;

        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }

    public function delete(string $id)
    {
        DB::beginTransaction();
        try {
            $user = User::find($id);
            if ($user) {
                $user->delete();
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }
};
