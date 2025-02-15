<?php

namespace App\Repositories;
use App\Models\Lead;
use App\Repositories\Interfaces\LeadRepositoryInterface;

class LeadRepository implements LeadRepositoryInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function getAllLeads()
    {
        return Lead::with('counselor')->get();
    }

    public function getLeadById($id)
    {
        return Lead::with('counselor')->findOrFail($id);
    }

    public function createLead(array $data)
    {
        return Lead::create($data);
    }

    public function updateLead($lead, array $data)
    {
        $lead = Lead::findOrFail($lead->id);
        $lead->update($data);
        return $lead;
    }

    public function deleteLead($id)
    {
        return Lead::destroy($id);
    }
}
