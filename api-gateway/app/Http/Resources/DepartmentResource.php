<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DepartmentResource extends JsonResource
{
    public function __construct(private $departmentData) {}    

    public function toArray(Request $request): array
    {
        return [
            'meta' => [
                'status' => 200,
                'msg' => 'Success',
            ],
            'data' => $this->departmentData,            
        ];
    }
}
