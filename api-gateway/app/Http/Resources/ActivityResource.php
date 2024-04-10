<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ActivityResource extends JsonResource {
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    private $activity;

    public function __construct($activity) {
        $this->activity = $activity;
    }

    public function toArray(Request $request): array {
        return [
            'meta' => [
                'status' => 200,
                'msg' => 'Success',
            ],
            'data' => [
                'ActivityData' => $this->activity,
            ]
        ];
    }
}
