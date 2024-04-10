<?php

namespace App\Services;

use App\Repositories\EngineerAssignRepository;

class EngineerAssignService {
    public function __construct(private EngineerAssignRepository $engineerAssignRepository) {
    }

    public function saveEngineerAssign(array $data): array {
        return $this->engineerAssignRepository->saveEngineerAssign($data);
    }
}
