<?php

namespace App\Http\Livewire\Admin;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;
class AdminProductComponent extends Component
{
    use WithPagination;
    public function deleteProduct($product_id)
    {
        $product = Product::findOrFail($product_id);
        $product->delete();
//        session()->flash('message', 'Product has been deleted!');
        return redirect()->route('admin.products');
    }
    public function render()
    {
        $products = Product::orderBy('created_at','DESC')->paginate(10);
        return view('livewire.admin.admin-product-component',['products' => $products]);
    }
}
