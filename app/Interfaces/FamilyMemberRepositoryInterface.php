<?php


namespace App\Interfaces;
Interface FamilyMemberRepositoryInterface
{
    public function getAll(
        ?string $search,
        ?int $limit,
        bool $execute,
    );

    public function getAllpaginated(
        ?string $search,
        int $rowPerPage,
    );
    public function getById(
        string $id
    );

    public function create(
        array $data
    );
    // public function update(
    //     string $id,
    //     array $data
    // );
    // public function delete(
    //      string $id
    // );
}