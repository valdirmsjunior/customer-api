<?php

namespace App\Services;

use App\Interfaces\CustomerRepositoryInterface;

class CustomerService
{
    public function __construct(protected CustomerRepositoryInterface $customerRepository)
    {
    }

    public function create(array $data)
    {
        return $this->customerRepository->create($data);
    }

    public function update(array $data, $id)
    {
        return $this->customerRepository->update($data, $id);
    }

    public function delete($id)
    {
        return $this->customerRepository->delete($id);
    }

    public function all()
    {
        return $this->customerRepository->all();
    }

    public function find($id)
    {
        return $this->customerRepository->find($id);
    }
}
