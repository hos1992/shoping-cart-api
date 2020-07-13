<?php

namespace App\Repositories\Eloquent;

use App\Models\Cart;
use App\Models\OrderProduct;
use App\Repositories\OrdersRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;

class  OrdersRepository extends BaseRepository implements OrdersRepositoryInterface {


    protected $cartModel;
    protected $orderProductModel;

    public function __construct(Order $model)
    {
        parent::__construct($model);
        $this->cartModel = new Cart();
        $this->orderProductModel = new OrderProduct();
    }

    public function placeOrder(array $req)
    {
        /*
         * get the cart data
         */
        $data['items'] = $this->cartModel->where('session_id', $req['session_id'])->with('product_details')->get();

        if(count($data['items']) == 0){
            return;
        }

        // get the subtotal
        $data['sub_total'] = $this->cartModel->where('session_id', $req['session_id'])->sum('product_final_price');
        if (isset($req['coupon']) && $req['coupon'] == 'A3000') {
            $discount = (10 / 100) * $data['sub_total'];
            $data['sub_total'] = $data['sub_total'] - $discount;
            $create['coupon'] = $req['coupon'];
        }

        if($req['shipping_method'] == 2){
            $delivery_fee = (5 / 100) * $data['sub_total'];
            $data['sub_total_plus_delivery_fee'] = $data['sub_total'] + $delivery_fee;
            $create['payment_method'] = 2;
        }else{
            $create['payment_method'] = 1;
        }

        // get the taxes
        $taxes = (10 / 100) * $data['sub_total'];

        // final total
        $create['final_total'] = $data['sub_total'] + $taxes + $delivery_fee;

        $create['session_id'] = $req['session_id'];
        $create['username'] = $req['username'];
        $create['email'] = $req['email'];
        $create['address'] = $req['address'];
        $create['shipping_method'] = $req['shipping_method'];

        // create the order
        $order = $this->model->create($create);

        // create the order products
        foreach ($data['items'] as $product){
            $order_product['order_id'] = $order->id;
            $order_product['product_id'] = $product->product_id;
            $order_product['quantity'] = $product->quantity;
            $order_product['product_final_price'] = $product->product_final_price;

            $this->orderProductModel->insert($order_product);
        }

        // delete this session from the cart
        $this->cartModel->where('session_id', $req['session_id'])->delete();

        return $this->model->where('id', $order->id)->with('products')->first();
    }

    public function getSessionOrders($session_id){
        return $this->model->where('session_id', $session_id)->with('products')->orderBy('id', 'DESC')->get();
    }

    public function changeStatus($req){

        $order_id = $req['order_id'];
        $status = $req['status'];
        $this->model->find($order_id)->update(['status' => $status]);
    }

}
