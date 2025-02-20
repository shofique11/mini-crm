<?php

namespace App\Http\Controllers;

use App\Http\Controllers\API\BaseController;
use App\Models\Application;
use App\Http\Requests\StoreApplicationRequest;
use App\Repositories\Interfaces\ApplicationRepositoryInterface;
use App\Http\Requests\UpdateApplicationRequest;

use Illuminate\Support\Facades\Gate;

class ApplicationController extends BaseController
{
    protected $applicationRepository;

    public function __construct(ApplicationRepositoryInterface $applicationRepository)
    {

        $this->applicationRepository = $applicationRepository;
    }
   
    public function index()
    {
        if (Gate::denies('viewAny', Application::class)) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }
        $success['applications'] = $this->applicationRepository->getAllApplication();
        return $this->sendResponse($success, 'All application showed successfully.', 200);
    }

   

    public function store(StoreApplicationRequest $request)
    {
        if (Gate::denies('create', Application::class)) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }
        $success['application'] = $this->applicationRepository->createApplication($request->all());
        return $this->sendResponse($success, 'Application created successfully.', 201);
    }

    public function show(Application $application)
    {
        if (Gate::denies('view', $application)) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }
       
        $success['application'] = $this->applicationRepository->getApplicationById($application->id);
        return $this->sendResponse($success, 'Application details showed successfully.', 200);
    }

    public function update(UpdateApplicationRequest $request, Application $application)
    {
         // Ensure lead exists
         if (! $application) {
            return response()->json(['message' => 'Application not found.'], 404);
        }
        if (Gate::denies('update', $application)) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }
        $success['application'] = $this->applicationRepository->updateApplication($application, $request->only('status'));
        return $this->sendResponse($success, 'Application updated successfully.', 200);
    }

    public function myApplication(){

        if (Gate::denies('viewAny', Application::class)) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }
        $success['user_applications'] = $this->applicationRepository->getMyApplication();
        return $this->sendResponse($success, 'User application showed successfully.', 200);
    }
}
