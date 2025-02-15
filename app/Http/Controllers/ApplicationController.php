<?php

namespace App\Http\Controllers;

use App\Http\Controllers\API\BaseController;
use App\Models\Application;
use App\Http\Requests\StoreApplicationRequest;
use App\Http\Requests\UpdateApplicationRequest;
use App\Repositories\Interfaces\ApplicationRepositoryInterface;
use Illuminate\Support\Facades\Gate;

class ApplicationController extends BaseController
{
    protected $applicationRepository;

    public function __construct(ApplicationRepositoryInterface $applicationRepository)
    {
        $this->applicationRepository = $applicationRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreApplicationRequest $request)
    {
        if (Gate::denies('create', Application::class)) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }
        $success['applications'] = $this->applicationRepository->createApplication($request->all());
        return $this->sendResponse($success, 'Application created successfully.', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Application $application)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateApplicationRequest $request, Application $application)
    {
         // Ensure lead exists
         if (! $application) {
            return response()->json(['message' => 'Lead not found.'], 404);
        }
        if (Gate::denies('update', $application)) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }
        $success['application'] = $this->applicationRepository->updateApplication($application, $request->only('status'));
        return $this->sendResponse($success, 'Lead updated successfully.', 200);
    }
}
