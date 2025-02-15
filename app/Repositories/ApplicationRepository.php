<?php

namespace App\Repositories;
use App\Models\Application;
use App\Repositories\Interfaces\ApplicationRepositoryInterface;
class ApplicationRepository implements ApplicationRepositoryInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Create a new application.
     *
     * @param array $data
     * @return Application
     */
    public function createApplication(array $data): Application
    {
        return Application::create($data);
    }

    /**
     * Update an existing application.
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function updateApplication($id, array $data): bool
    {
        $application = Application::find($id);
        if ($application) {
            return $application->update($data);
        }
        return false;
    }
}
