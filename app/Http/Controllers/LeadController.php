<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Http\Requests\StoreLeadRequest;
use App\Http\Requests\UpdateLeadRequest;
use App\Repositories\Interfaces\LeadRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;

class LeadController extends Controller
{
    use AuthorizesRequests;
   

    // public function __construct()
    // {
    //    dd("create laed");
    // }
    /**
     * Send error response.
     */

    protected $leadRepository;

    public function __construct(LeadRepositoryInterface $leadRepository)
    {
        $this->leadRepository = $leadRepository;
    }
    public function sendError($error, $errorMessages = [], $code = 404)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];

        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //return response()->json($this->leadRepository->getAllLeads());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLeadRequest $request)
    {
       
        $this->authorize('create', Lead::class);

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:leads',
            'phone' => 'nullable|string',
            'status' => 'required|in:In Progress,Bad Timing,Not Interested,Not Qualified',
            'counselor_id' => 'required|exists:users,id',
         ]);
       
         $request['assigned_to' ] = $request['counselor_id'];
         if($validator->fails()){
             return $this->sendError('Validation Error.', $validator->errors());       
         }

        return response()->json($this->leadRepository->createLead($request->all()), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Lead $lead)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lead $lead)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLeadRequest $request, Lead $lead)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:In Progress,Bad Timing,Not Interested,Not Qualified',
         ]);
 
         if($validator->fails()){
             return $this->sendError('Validation Error.', $validator->errors());       
         }
       // return response()->json($this->leadRepository->getLeadById($lead->id));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lead $lead)
    {
        //$this->leadRepository->deleteLead($lead->id);
        return response()->json(['message' => 'Lead deleted successfully']);
    }
}
