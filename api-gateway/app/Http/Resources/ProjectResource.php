<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    private $projectData;
    
    public function __construct($projectData)
    {
        $this->projectData = $projectData;
    }

    public function toArray(Request $request): array
    {
        return [
            'meta' => [
                'status' => 200,
                'msg' => 'Success',
            ],
            'data' => $this->projectData,
        ];
    }
}
