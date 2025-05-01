<?php

use PHPUnit\Framework\TestCase;
require_once __DIR__ . '/../classes/CartHandler.php';

class CartHandlerTest extends TestCase
{
    private $cart;
    private $handler;

    protected function setUp(): void
    {
        $this->cart = [];
        $this->handler = new CartHandler($this->cart);
    }

    public function testAddItem()
    {
        $this->handler->addItem(['id' => 1, 'name' => 'Item1', 'qty' => 2, 'price' => 10]);
        $this->assertEquals(2, $this->handler->getCart()[1]['qty']);
    }

    public function testUpdateQuantity()
    {
        $this->handler->addItem(['id' => 2, 'name' => 'Item2', 'qty' => 1, 'price' => 5]);
        $this->handler->updateQuantity(2, 4);
        $this->assertEquals(4, $this->handler->getCart()[2]['qty']);
    }

    public function testRemoveItem()
    {
        $this->handler->addItem(['id' => 3, 'name' => 'Item3', 'qty' => 1, 'price' => 8]);
        $this->handler->removeItem(3);
        $this->assertArrayNotHasKey(3, $this->handler->getCart());
    }

    public function testEmptyCart()
    {
        $this->handler->addItem(['id' => 4, 'name' => 'Item4', 'qty' => 2, 'price' => 12]);
        $this->handler->emptyCart();
        $this->assertEmpty($this->handler->getCart());
    }

    public function testCalculateTotal()
    {
        $this->handler->addItem(['id' => 5, 'name' => 'Item5', 'qty' => 2, 'price' => 5]);
        $this->handler->addItem(['id' => 6, 'name' => 'Item6', 'qty' => 1, 'price' => 10]);
        $this->assertEquals(20, $this->handler->calculateTotal());
    }
}