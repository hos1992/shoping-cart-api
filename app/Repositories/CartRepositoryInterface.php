<?php

namespace App\Repositories;

interface CartRepositoryInterface {

    public function addToCart(array $data);

    public function getCart($session_id);

    public function updateQuantity(array $data);

    public function applyCoupon(array  $data);

}
