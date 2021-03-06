<?php

namespace App\Http\Controllers\Api;

use App\Cart;
use App\Http\Resources\CartResource;
use App\Http\Resources\ProductResource;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{

    public function index(){
        $user = Auth::user();
        $cart = $user ->cart;
       $cartItems = json_decode($cart->cart_items);
       $finalCartItems = [];
       foreach($cartItems as $cartItem){
           $product = Product::find(intVal($cartItem->product->id));
           $finalCartItem = new\stdClass();
           $finalCartItem->product = new ProductResource($product);
           $finalCartItem->qty = number_format(doubleval($cartItem->qty) , 2);
           array_push($finalCartItems , $finalCartItem);
       }

       return [
         'cart_items' => $finalCartItems,
           'id' => $cart->id,
           'total' => $cart->total,
       ];

        return$cart;

    }
    public function addProductToCart(Request $request){
        $request->validate([
            'product_id' => 'required',
            'qty' => 'required',
        ]);
        $user = Auth::user();
        $product_id = $request ->input('product_id');
        $qty = $request->input('qty');
        $product = Product::findorFail($product_id);



        /**
         * @var Cart
         */
        $cart = $user->cart;
        if(is_null($cart)){
            $cart = new Cart();
            $cart->cart_items =[];
            $cart -> total =0;
            $cart ->user_id = Auth::user()->id;
        }

        //check if product alreay in cart
        if($cart -> inItems($product_id)){
            //if exist increase qty
            $cart ->increaseProductInCart($product , $qty);
        }else{
            //add to cart
            $cart->addProductToCart($product ,$qty);

        }
        //return $cart;

        $cart ->save();
        $user->cart_id = $cart->id;
        $user ->save();
        return $cart;
        //return new CartResource($cart);

        // TODO : return response
    }

    private function checkCartStatus(Cart $cart = null){
        if(is_null($cart)){
            $cart = new  Cart();
            $cart->cart_items =[];
            $cart -> total =0;
            $cart ->user_id = Auth::user()->id;
            return $cart;
        }
        return $cart;
    }
}
