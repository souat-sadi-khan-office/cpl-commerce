<?php

namespace App\Repositories\Interface;

interface CustomerRepositoryInterface
{
    public function getAllCustomers();
    public function dataTable();
    public function findCustomerById($id);
    public function createCustomer($data);
    public function updateCustomer($id, $data);
    public function deleteCustomer($id);
    public function updateStatus($request, $id);
}
