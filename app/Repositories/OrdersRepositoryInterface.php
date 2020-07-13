<?php

namespace App\Repositories;

interface OrdersRepositoryInterface
{
    public function placeOrder(array $data);

    public function getSessionOrders($session_id);

    public function changeStatus(array $data);
}
