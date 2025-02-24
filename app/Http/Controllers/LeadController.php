<?php
namespace App\Http\Controllers;

use App\Http\Controllers\API\BaseController;
use App\Http\Requests\StoreLeadRequest;
use App\Http\Requests\UpdateLeadRequest;
use App\Http\Requests\UpdateStatusRequest;
use App\Models\Lead;
use App\Repositories\Interfaces\LeadRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class LeadController extends BaseController
{

    protected $leadRepository;

    public function __construct(LeadRepositoryInterface $leadRepository)
    {
        $this->leadRepository = $leadRepository;
    }

    public function index()
    {
        $success['leads'] = $this->leadRepository->getAllLeads();
        return $this->sendResponse($success, 'All leads showed successfully.', 200);
    }

    public function store(StoreLeadRequest $request)
    {
        if (Gate::denies('create', Lead::class)) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }
        $success['lead'] = $this->leadRepository->createLead($request->all());
        return $this->sendResponse($success, 'Lead created successfully.', 201);
    }

    public function show(Lead $lead)
    {

        if (Gate::denies('view', $lead)) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }

        $success['leads'] = $this->leadRepository->getLeadById($lead->id);
        return $this->sendResponse($success, 'Lead details showed successfully.', 200);
    }

    public function counselorLeads()
    {
        $success['leads'] = $this->leadRepository->getLeadByCounselor(Auth::user()->id);
        return $this->sendResponse($success, 'Lead details showed successfully.', 200);
    }
    public function update(UpdateLeadRequest $request, Lead $lead)
    {
        // Ensure lead exists
        if (! $lead) {
            return response()->json(['message' => 'Lead not found.'], 404);
        }
        if (Gate::denies('update', $lead)) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }

        $success['lead'] = $this->leadRepository->updateLead($lead, $request->all());
        return $this->sendResponse($success, 'Lead updated successfully.', 200);
    }

    public function destroy(Lead $lead)
    {

        if (Gate::denies('delete', $lead)) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }
        $this->leadRepository->deleteLead($lead->id);
        return response()->json(['message' => 'Lead deleted successfully', 200]);
    }
    public function updateStatus(UpdateStatusRequest $request, $id)
    {
        $lead         = Lead::findOrFail($id);
        $lead->status = $request->status;
        $lead->save();

        return response()->json(['message' => 'Lead status updated successfully!']);
    }
}
