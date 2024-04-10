<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectAssignResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function __construct(private $responseData) {} 

    public function toArray(Request $request): array
    {
            return [
                'meta' => [
                    'status' => 200,
                    'msg' => 'Success',
                ],
                'data' => [
                    'EngineerAssignData' => $this->responseData,
                ]
            ];
    }
}
