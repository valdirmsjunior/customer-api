<?php

namespace App\Http\Controllers;

use App\Http\Controllers\API\BaseController;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use App\Services\CustomerService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomerController extends BaseController
{
    public function __construct(protected CustomerService $customerService) {

    }

    public function index(): JsonResponse
    {
        $customer = $this->customerService->all();
        return $this->sendResponse(CustomerResource::collection($customer), 'Customer retrieved successfully.');

    }

    public function show($id)
    {
        $customer = $this->customerService->find($id);

        if (is_null($customer)) {
            return $this->sendError('Customer not found.');
        }

        return $this->sendResponse(new CustomerResource($customer), 'Customer retrieved successfully.');

    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:customers|max:255',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $customer = $this->customerService->create($request->all());

        return $this->sendResponse(new CustomerResource($customer), 'Customer created successfully.');

    }
    public function update(Request $request, Customer $customer): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:customers,email,' . $customer->id,
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $custome = $this->customerService->update($request->all(), $customer->id);

        return $this->sendResponse(new CustomerResource($custome), 'Customer updated successfully.');

    }

    public function destroy(Customer $customer): JsonResponse
    {
        $this->customerService->delete($customer->id);

        return $this->sendResponse([], 'Customer deleted successfully.');
    }
}
