<?php

namespace App\Repositories;

use App\Models\MemberType;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class MemberTypeRepository
{
    public function getAllMemberType() : Collection
    {
       try {
           DB::beginTransaction();
           $memberType = MemberType::all();
           DB::commit();
           return $memberType;
       } catch (\Exception $e) {
           DB::rollBack();
           throw $e;
       }
    }
}