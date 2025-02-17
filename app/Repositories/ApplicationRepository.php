<?php

namespace App\Repositories;
use App\Models\Application;
use App\Repositories\Interfaces\ApplicationRepositoryInterface;
class ApplicationRepository implements ApplicationRepositoryInterface
{
   
    public function __construct()
    {
        //
    }

    public function getAllApplication()
    {
        return Application::with('counselor')->get();
    }

    public function getApplicationById($id)
    {
        return Application::with('counselor')->findOrFail($id);
    }
   
    public function createApplication(array $data): Application
    {
        return Application::create($data);
    }

    public function updateApplication($application, array $data)
    {
        $application = Application::find($application->id);
        if ($application) {
             $application->update($data);
             return $data;
        }
        return false;
    }
}
