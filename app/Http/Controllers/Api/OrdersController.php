<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\OrdersRepositoryInterface;
use Illuminate\Http\Request;
use Validator;

class OrdersController extends Controller
{

    private $orderRepository;

    public function __construct(OrdersRepositoryInterface $repository)
    {
        $this->orderRepository = $repository;
    }


    public function placeOrder(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'session_id' => 'required',
            'username' => 'required',
            'email' => 'required|email',
            'address' => 'required',
            'shipping_method' => 'required|in:1,2',
//            'coupon' => 'required',

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
        $data['msg'] = 'Order created successfully';
        $data['order'] = $this->orderRepository->placeOrder($request->all());

        return $data;


    }

    public function getSessionOrders(Request $request)
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
        $data['orders'] = $this->orderRepository->getSessionOrders($request->session_id);

        return $data;

    }

    public function changeOrderStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required',
            'status' => 'required|in:0,1,2,3,4',
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

        $this->orderRepository->changeStatus($request->all());

        $data['status'] = 1;
        $data['msg'] = 'Status changed successfully';

        return  $data;


    }
}
