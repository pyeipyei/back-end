<?php

namespace App\Http\Controllers;

use App\Services\MemberTypeService;
use App\Http\Resources\MemberTypeResource;
use Illuminate\Support\Facades\Response;

class MemberTypeController extends Controller
{
    public function __construct(private MemberTypeService $memberTypeService) {} 

    public function index()
    {
        try{
            $responseData = $this->memberTypeService->getAllMemberType();
            return  new MemberTypeResource($responseData);
        } catch (\Exception $e){
            // Handle exceptions and errors
            return Response::error($e->getMessage(), 500);
        }
    }
}
