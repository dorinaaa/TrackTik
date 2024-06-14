<?php

namespace App\Consumer;

use App\Consumer\Base\ApiGateway;
use Exception;

class EmployeeConsumerApi extends ApiGateway
{
    protected string $entityPath;

    /**
     * @throws Exception
     */
    public function createOrUpdateEmployee(array $data): array
    {
        if ($this->employeeExists($data)) {
            return $this->updateEmployee($data['id'], $data);
        }
        return $this->post($this->entityPath, $data);
    }

    /**
     * @throws Exception
     */
    public function updateEmployee($id, $data): array
    {
        return $this->put("{$this->entityPath}/{$id}", $data);
    }

    public function deleteEmployee($id): void
    {
        $this->delete("{$this->entityPath}/{$id}");
    }

    /**
     * @throws Exception
     */
    public function getEmployee($id): array
    {
        return $this->get("{$this->entityPath}/{$id}");
    }

    /**
     * @throws Exception
     */
    public function getEmployees($filters = []): array
    {
        return $this->get($this->entityPath, $filters);
    }

    private function employeeExists($data): bool
    {
        // TODO: DB Layer. It would be better to check if the employee exists in the DB before making multiple requests to the API
        return false;
    }

}