<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Livewire\Component;

class HomeComponent extends Component
{
    public function store($product_id, $product_name, $product_price)
    {
        Cart::add($product_id, $product_name,1, $product_price)->associate('\App\Models\Product');
        session()->flash('success message', 'Item added to Cart');
        return redirect()->route('shop.cart');
    }
    public function render()

    {
        $lproducts = Product::orderBy('created_at','DESC')->get()->take(8);
        $fproducts =Product::where('featured',1)->inRandomOrder()->get()->take(8);
        $pcategories = Category::where('is_popular',1)->inRandomOrder()->get()->take(8);
        return view('livewire.home-component', ['lproducts' => $lproducts,'fproducts'=>$fproducts,'pcategories'=>$pcategories]);

    }
}
