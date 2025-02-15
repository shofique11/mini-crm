<?php

namespace App\Repositories\Interfaces;

interface ApplicationRepositoryInterface
{
    public function createApplication(array $data);
    public function updateApplication($id, array $data);

}
