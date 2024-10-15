<?php

namespace App\Http\Controllers;

use App\Http\Controllers\API\BaseController;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomerController extends BaseController
{

    public function index(): JsonResponse
    {
        $customer = Customer::all();
        return $this->sendResponse(CustomerResource::collection($customer), 'Customer retrieved successfully.');

    }

    public function show($id)
    {
        $customer = Customer::findOrFail($id);

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

        $customer = Customer::create($request->all());

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

        $customer->update($request->all());

        return $this->sendResponse(new CustomerResource($customer), 'Customer updated successfully.');

    }

    public function destroy(Customer $customer): JsonResponse
    {
        $customer->delete();

        return $this->sendResponse([], 'Customer deleted successfully.');
    }
}
