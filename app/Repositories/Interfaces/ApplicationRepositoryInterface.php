<?php

namespace App\Repositories\Interfaces;

interface ApplicationRepositoryInterface
{
    public function getAllApplication();
    public function getApplicationById($id);
    public function createApplication(array $data);
    public function updateApplication($id, array $data);
    public function deleteApplication($id);
    public function getMyApplication();

}
