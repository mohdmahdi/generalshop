<?php

namespace App;

use phpDocumentor\Reflection\Types\Parent_;

class CartItem
{
    /**
     * @var $product Product
     */
    public $product ;
    public  $qty;

    /**
     * CartItem constructor.
     * @param Product $product
     * @param $qty
     */
    public function __construct(Product $product, $qty)
    {
        $this->product = $product;
        $this->qty = $qty;
        //parent::__Construct();

    }

}
