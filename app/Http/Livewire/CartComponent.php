<?php

namespace App\Http\Livewire;
use Gloudemans\Shoppingcart\Facades\Cart;
use Livewire\Component;

class CartComponent extends Component

{
    public function increaseQuantity($rowId){
        $product = Cart::get($rowId);
        $qty = $product->qty +1 ;
        Cart::update($rowId,$qty);
        $this->emit('cart-icon-component','refresh-component');
    }
    public function decreaseQuantity($rowId){
        $product = Cart::get($rowId);
        $qty = $product->qty -1 ;
        Cart::update($rowId,$qty);
        $this->emit('cart-icon-component','refresh-component');
    }
    public function destroy($id){
        Cart::remove($id);
        session()->flash('success message', 'Item has been removed');
        $this->emit('cart-icon-component','refresh-component');
    }
    public function clearAll(){
        Cart::destroy();
        $this->emit('cart-icon-component','refresh-component');
    }
    public function render()
    {
        return view('livewire.cart-component');
    }
}
