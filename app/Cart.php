<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
   protected $fillable =[
       'cart_items' , 'total', 'user_id'

   ];

   public function user(){
       return $this->belongsTo(User::class);
   }

    public function order(){
        return $this->belongsTo(Order::class);
    }



    public function increaseProductInCart(Product $product , $qty=1){
       $cartItems = $this->cart_items;
       if(is_null($cartItems)){
           $cartItems = [];
       }else{
           if(!is_array($cartItems)){
               $cartItems = json_decode($cartItems);
           }
       }

       /**
        * @var $cartItem CartItem
        */


       foreach ( $cartItems as $cartItem ){
           if($cartItem->product->id === $product->id){
               $cartItem->qty += $qty;
           }
       }
        $this->cart_items = json_encode($cartItems);

    }

    public function addProductToCart(Product $product , $qty = 1){
        $cartItems = $this->cart_items;
        if(is_null($cartItems)){
            $cartItems = [];
        }else{
            if(!is_array($cartItems)){
                $cartItems = json_decode($cartItems);
            }
        }
        /**
         * @var $cartItem CartItem
         */
        $cartItem = new CartItem($product , $qty);
        array_push($cartItems , $cartItem);
        $this->cart_items = json_encode($cartItems);
        return $cartItems;

    }


    public function inItems($product_id){
        $cartItems = $this->cart_items;
        if(is_null($cartItems)){
            $cartItems = [];
        }else{
            if(!is_array($cartItems)){
                $cartItems = json_decode($cartItems);
            }
        }
        //return $cartItems;

        /**
         * @var $cartItem CartItem
         */
        //return $cartItems;

        foreach($cartItems as $cartItem) {

            if($product_id == $cartItem->product->id){
                return true;
            }
        }
        return false;
    }

}
