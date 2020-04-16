<?php

namespace App;

class Cart
{
    /**
     * @var array Items
     */
    public $items = null;

    /**
     * @var int Quantity items
     */
    public $totalQuantity = 0;

    /**
     * @var double Pure price of items
     */
    public $totalPurePrice = 0;

    /**
     * @var double Price of items
     */
    public $totalPrice = 0;

    /**
     * @var double Discount price of items
     */
    public $totalDiscountPrice = 0;

    /**
     * @var double Discount of coupon
     */
    public $couponDiscount = 0;

    /**
     * @var array Coupon data items
     */
    public $coupon = null;

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
        if (isset($item->discount_price)) {
            $storedItem['price'] = $item->discount_price * $storedItem['quantity'];
            $this->totalPrice += $item->discount_price;
            $this->totalDiscountPrice += ($item->price - $item->discount_price);
        } else {
            $storedItem['price'] = $item->price * $storedItem['quantity'];
            $this->totalPrice += $item->price;
        }
        $this->items[$id] = $storedItem;
        $this->totalQuantity++;
        $this->totalPurePrice += $item->price;
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
            if (isset($item->discount_price)) {
                $this->items[$id]['price'] -= $item->discount_price;
                $this->totalPrice -= $item->discount_price;
                $this->totalDiscountPrice -= ($item->price - $item->discount_price);
            } else {
                $this->items[$id]['price'] -= $item->price;
                $this->totalPrice -= $item->price;
            }
            $this->totalQuantity--;
            $this->totalPurePrice -= $item->price;
            if ($this->items[$id]['quantity'] > 1) {
                $this->items[$id]['quantity']--;
            } else {
                unset($this->items[$id]);
            }
        }
        return;
    }

    /**
     * Applies coupon discount
     *
     * @param  Coupon  $coupon
     * @return void
     */
    public function addCoupon(Coupon $coupon)
    {
        $couponData = ['price' => $coupon->price, 'coupon' => $coupon];
        $this->coupon = $couponData;
        $this->totalPrice -= $couponData['price'];
        $this->couponDiscount += $couponData['price'];
    }
}
