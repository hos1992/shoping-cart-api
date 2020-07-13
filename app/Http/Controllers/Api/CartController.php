<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\CartRepositoryInterface;
use Illuminate\Http\Request;
use Validator;

class CartController extends Controller
{

    private $cartRepository;

    public function __construct(CartRepositoryInterface $repository)
    {
        $this->cartRepository = $repository;
    }

    public function getCart(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'session_id' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = [];
            $errors_str = "";
            foreach ($validator->errors()->toArray() as $key => $error) {
                $errors[$key] = $error[0];
                $errors_str = $errors_str . $error[0] . "\n";
            }
            $data['status'] = 0;
            $data['errors'] = $errors;
            return $data;
        }

        $data['status'] = 1;
        $data['cart'] = $this->cartRepository->getCart($request->session_id);

        return $data;

    }

    public function addToCart(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'session_id' => 'required',
            'product_id' => 'required|numeric',
            'products_price' => 'required|numeric',
            'quantity' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            $errors = [];
            $errors_str = "";
            foreach ($validator->errors()->toArray() as $key => $error) {
                $errors[$key] = $error[0];
                $errors_str = $errors_str . $error[0] . "\n";
            }
            $data['status'] = 0;
            $data['errors'] = $errors;
            return $data;
        }

        $this->cartRepository->addToCart($request->all());

        $data['status'] = 1;
        $data['msg'] = "Product Added Successfully";
        return $data;

    }

    public function updateQuantity(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cart_id' => 'required|numeric',
            'product_price' => 'required|numeric',
            'quantity' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            $errors = [];
            $errors_str = "";
            foreach ($validator->errors()->toArray() as $key => $error) {
                $errors[$key] = $error[0];
                $errors_str = $errors_str . $error[0] . "\n";
            }
            $data['status'] = 0;
            $data['errors'] = $errors;
            return $data;
        }

        $this->cartRepository->updateQuantity($request->all());

        $data['status'] = 1;
        $data['msg'] = "Quantity Updated Successfully";
        return $data;


    }

    public function applyCoupon(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'session_id' => 'required',
            'coupon' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = [];
            $errors_str = "";
            foreach ($validator->errors()->toArray() as $key => $error) {
                $errors[$key] = $error[0];
                $errors_str = $errors_str . $error[0] . "\n";
            }
            $data['status'] = 0;
            $data['errors'] = $errors;
            return $data;
        }

        $data['status'] = 1;
        $data['msg'] = "this cart with coupon applied";
        $data['cart'] = $this->cartRepository->applyCoupon($request->all());

        return $data;

    }
}
