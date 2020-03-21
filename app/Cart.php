<?php

namespace App;

class Cart
{
    /**
     * @var array Items
     */
    public $items = null;

    /**
     * @var int Quantity of each item
     */
    public $totalQuantity = 0;

    /**
     * @var double Discount price of each item
     */
    public $totalPurePrice = 0;

    /**
     * @var double Price of each item
     */
    public $totalPrice = 0;

    /**
     * @var double Discount price of each item
     */
    public $totalDiscountPrice = 0;

    /**
     * Creates a new instance App\Cart
     *
     * @param  Cart|null  $oldCart
     */
    public function __construct(Cart $oldCart = null)
    {
        if (isset($oldCart)) {
            $this->items = $oldCart->items;
            $this->totalQuantity = $oldCart->totalQuantity;
            $this->totalPurePrice = $oldCart->totalPurePrice;
            $this->totalPrice = $oldCart->totalPrice;
            $this->totalDiscountPrice = $oldCart->totalDiscountPrice;
        }
    }

    /**
     * Adds a new item to cart
     *
     * @param  Product  $item
     * @param  int  $id
     *
     * @return void
     */
    public function add(Product $item, $id)
    {
        $storedItem = $item->discount_price ? [
            'quantity' => 0,
            'price' => $item->discount_price,
            'item' => $item
        ] : ['quantity' => 0, 'price' => $item->price, 'item' => $item];
        if (isset($this->items) && array_key_exists($id, $this->items)) {
            $storedItem = $this->items[$id];
        }
        $storedItem['quantity']++;
        $this->items[$id] = $storedItem;
        $this->totalQuantity++;
        $this->totalPurePrice += $item->price;
        if (isset($item->discount_price)) {
            $storedItem['price'] = $item->discount_price * $storedItem['quantity'];
            $this->totalPrice += $item->discount_price;
            $this->totalDiscountPrice += ($item->price - $item->discount_price);

            return;
        }
        $storedItem['price'] = $item->price * $storedItem['quantity'];
        $this->totalPrice += $item->price;
    }

    /**
     * Removes an item from cart
     *
     * @param  Product  $item
     * @param  int  $id
     *
     * @return void
     */
    public function remove($item, $id)
    {
        if (isset($this->items) && array_key_exists($id, $this->items)) {
            $this->totalQuantity--;
            $this->totalPurePrice -= $item->price;
            if (isset($item->discount_price)) {
                $this->totalPrice -= $item->discount_price;
                $this->totalDiscountPrice -= ($item->price - $item->discount_price);
            } else {
                $this->totalPrice -= $item->price;
            }
            if ($this->items[$id]['quantity'] > 1) {
                $this->items[$id]['quantity']--;
            } else {
                unset($this->items[$id]);
            }
        }
        return;
    }
}
