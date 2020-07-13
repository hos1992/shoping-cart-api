<?php

namespace App\Repositories\Eloquent;

use App\Models\Cart;
use App\Repositories\CartRepositoryInterface;

class CartRepository extends BaseRepository implements CartRepositoryInterface
{


    public function __construct(Cart $model)
    {
        parent::__construct($model);
    }

    public function addToCart(array $data)
    {
        $create['session_id'] = $data['session_id'];
        if (isset($data['user_id']) && !empty($data['user_id'])) {
            $create['user_id'] = $data['user_id'];
        }
        $create['product_id'] = $data['product_id'];
        $create['quantity'] = $data['quantity'];
        $create['product_final_price'] = $data['quantity'] * $data['products_price'];

        // check if the cart has the product for this session
        $check = $this->model->where([
            ['session_id', '=', $data['session_id']],
            ['product_id', '=', $data['product_id']]
        ])->first();
        if ($check) {
            $check->update($create);
        } else {
            $this->model->create($create);
        }
    }

    public function getCart($session_id)
    {

        $data['items'] = $this->model->where('session_id', $session_id)->with('product_details')->get();

        // get the subtotal
        $data['sub_total'] = $this->model->where('session_id', $session_id)->sum('product_final_price');

        // get the taxes
        $taxes = (10 / 100) * $data['sub_total'];

        // subtotal plus taxes
        $data['sub_total_plus_taxes'] = $data['sub_total'] + $taxes;

        return $data;

    }

    public function updateQuantity(array $data)
    {
        $cart = $this->model->find($data['cart_id']);
        if ($cart) {
            $cart->quantity = $data['quantity'];
            $cart->product_final_price = $data['product_price'] * $data['quantity'];
            $cart->save();
        }
    }

    public function applyCoupon(array $req)
    {
        $data['items'] = $this->model->where('session_id', $req['session_id'])->with('product_details')->get();

        // get the subtotal
        $data['sub_total'] = $this->model->where('session_id', $req['session_id'])->sum('product_final_price');

        if ($req['coupon'] == 'A3000') {
            $discount = (10 / 100) * $data['sub_total'];
            $data['sub_total'] = $data['sub_total'] - $discount;
        }

        // get the taxes
        $taxes = (10 / 100) * $data['sub_total'];

        // subtotal plus taxes
        $data['sub_total_plus_taxes'] = $data['sub_total'] + $taxes;

        return $data;
    }

}
