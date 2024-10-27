<?php

namespace App\Repositories\Interface;

interface OrderRepositoryInterface
{
 public function index($request);
 public function store($request);
 public function indexDatatable($request);
 public function details($id);
 public function updateStatus($request, $orderId);
}