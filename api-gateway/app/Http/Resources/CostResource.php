<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    private $costData;
    
    public function __construct($costData)
    {
        $this->costData = $costData;
    }

    public function toArray(Request $request): array
    {
        return [
            'meta' => [
                'status' => 200,
                'msg' => 'Success',
            ],
            'data' => [
                'costData' => $this->costData,
            ]
        ];
    }
}
