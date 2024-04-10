<?php

namespace App\Services;

use App\Repositories\MemberTypeRepository;
use Illuminate\Support\Collection;

class MemberTypeService
{
    public function __construct(private MemberTypeRepository $memberTypeRepository) {}

    public function getAllMemberType(): Collection
    {
        $allMemberType = $this->memberTypeRepository->getAllMemberType();
        return collect($allMemberType);
    }
}