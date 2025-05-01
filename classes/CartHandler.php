<?php

class CartHandler
{
    private $cart;

    public function __construct(&$sessionCart)
    {
        $this->cart = &$sessionCart;
    }

    public function addItem($product)
    {
        $id = $product['id'];
        $qty = $product['qty'];

        if (isset($this->cart[$id])) {
            $this->cart[$id]['qty'] += $qty;
        } else {
            $this->cart[$id] = $product;
        }
    }

    public function updateQuantity($id, $qty)
    {
        if (!isset($this->cart[$id])) return;

        if ($qty <= 0) {
            $this->removeItem($id);
        } else {
            $this->cart[$id]['qty'] = $qty;
        }
    }

    public function removeItem($id)
    {
        unset($this->cart[$id]);
    }

    public function emptyCart()
    {
        $this->cart = [];
    }

    public function getCart()
    {
        return $this->cart;
    }

    public function calculateTotal()
    {
        $total = 0;
        foreach ($this->cart as $item) {
            $total += $item['price'] * $item['qty'];
        }
        return $total;
    }
}