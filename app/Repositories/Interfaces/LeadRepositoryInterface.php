<?php

namespace App\Repositories\Interfaces;

interface LeadRepositoryInterface
{
    public function getAllLeads();
    public function getLeadById($id);
    public function createLead(array $data);
    public function updateLead($id, array $data);
    public function deleteLead($id);
    public function getLeadByCounselor($id);
}
