<?php

namespace App\Http\Controllers;


use App\Http\Requests\ValidateRequest;
use App\Models\RequestModel;
use App\Utils\CoreUtil;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class RequestController extends Controller
{
    protected $coreUtil;

    public function __construct(CoreUtil $coreUtil)
    {
        $this->coreUtil = $coreUtil;
    }

    // List of Requests
    public function index(Request $request)
    {
        try {
            $requests = RequestModel::all();
            return $this->coreUtil->sendResponse(true, $requests, 'Requests retrieved successfully.', null);
        } catch (\Exception $e) {
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            return $this->coreUtil->sendResponse(false, null, 'Failed to fetch requests.', null);
        }
    }
    // Get Request details for edit view
    public function edit(Request $request, $id)
    {
        try {
            $request = RequestModel::find($id);
            return $this->coreUtil->sendResponse(true, $request, 'Request retrieved successfully.', null);
        } catch (\Exception $e) {
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            return $this->coreUtil->sendResponse(false, null, 'Failed to fetch requests.', null);
        }
    }
    // Store a new Request
    public function store(ValidateRequest $request)
    {
        try {
            $requestData = $request->only([
                'created_on',
                'location',
                'service',
                'status',
                'priority',
                'department',
                'request_by',
                'assigned_to'
            ]);
            $newRequest = RequestModel::create($requestData);
            return $this->coreUtil->sendResponse(true, $newRequest, 'Request created successfully.', null);
        } catch (\Exception $e) {
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            return $this->coreUtil->sendResponse(false, null, 'Failed to create request.', null);
        }
    }

    // Update a Request
    public function update(ValidateRequest $request, $id)
    {
        try {
            $requestData = $request->only([
                'created_on',
                'location',
                'service',
                'status',
                'priority',
                'department',
                'request_by',
                'assigned_to'
            ]);

            $existingRequest = RequestModel::findOrFail($id);
            $existingRequest->update($requestData);

            return $this->coreUtil->sendResponse(true, $existingRequest, 'Request updated successfully.', null);
        } catch (\Exception $e) {
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            return $this->coreUtil->sendResponse(false, null, 'Failed to update request.', null);
        }
    }

    // Delete a Request
    public function destroy(Request $request, $id)
    {
        try {
            $existingRequest = RequestModel::findOrFail($id);
            $existingRequest->delete();
            return $this->coreUtil->sendResponse(true, null, 'Request deleted successfully.', null);
        } catch (\Exception $e) {
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            return $this->coreUtil->sendResponse(false, null, 'Failed to delete request.', null);
        }
    }
}
