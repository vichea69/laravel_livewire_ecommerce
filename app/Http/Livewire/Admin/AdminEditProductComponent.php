<?php
//
//namespace App\Http\Livewire\Admin;
//
//use App\Models\Product;
//use Livewire\Component;
//use App\Models\Category;
//use Illuminate\Support\Str;
//use Livewire\WithFileUploads;
//
//class AdminEditProductComponent extends Component
//{
//    use WithFileUploads;
//    public $product_id;
//    public $name;
//    public $slug;
//    public $short_description;
//    public $description;
//    public $regular_price;
//    public $sell_price;
//    public $SKU;
//    public $stock_status  = 'instock';
//    public $featured = 0;
//    public $quantity;
//    public $image;
//    public $category_id;
//    public $newimage;
//
//    public function mount($product_id){
//        $product = Product::find($product_id);
//        $this->product_id = $product->id;
//        $this->name = $product->name;
//        $this->slug = $product->slug;
//        $this->short_description = $product->short_description;
//        $this->description = $product->description;
//        $this->regular_price = $product->regular_price;
//        $this->sell_price =$product->sell_price;
//        $this->SKU =$product->SKU;
//        $this->stock_status = $product->stock_status;
//        $this->featured = $product->featured;
//        $this->quantity = $product->quantity;
//        $this->image = $product->image;
//        $this->category_id = $product->category_id;
//        //dd($this->product_id,$this->name,$this->slug,$this->short_description,$this->description,$this->regular_price,$this->sell_price,$this->SKU,$this->stock_status,$this->featured ,$this->quantity,$this->image ,$this->category_id  );
//    }
//    public function generateSlug(){
//        $this->slug = Str::slug($this->name);
//    }
//    public function updateProduct(){
//        $this->validate([
//            'name'=>'required',
//            'slug'=>'required',
//            'short_description'=>'required',
//            'description'=>'required',
//            'regular_price'=>'required',
//            'sell_price'=>'required',
//            'SKU'=>'required',
//            'stock_status'=>'required',
//            'featured'=>'nullable',
//            'quantity'=>'required',
//            'image' => 'required|image|mimes:jpg,png,jpeg,gif|max:20000',
//            'category_id'=>'required',
//
//            ]);
//        $product =  Product::find($this->product_id);
//        $product->name = $this->name;
//        $product->slug = $this->slug;
//        $product->short_description = $this->short_description;
//        $product->description = $this->description;
//        $product->regular_price = $this->regular_price;
//        $product->sell_price =$this->sell_price;
//        $product->SKU =$this->SKU;
//        $product->stock_status = $this->stock_status;
//        $product->featured = $this->featured;
//        $product->quantity = $this->quantity;
//
//
//        if ($this->newimage) {
//            unlink('assets/images/products/' . $product->image);
//            $extension = $this->newimage->extension();
//            $fileName = date('ymdHis') . '.' . $extension;
//            $this->newimage->storeAs('products', $fileName);
//            $product->image = $fileName;
//        }
//
//        $product->featured = $this->featured ?? 0;
//        $product->category_id = $this->category_id;
//        $product->save();
//        session()->flush('message','Product has benn updated');
//
//    }
//    public function render()
//    {
//        $categories = Category::orderBy('name','ASC')->get();
//        return view('livewire.admin.admin-edit-product-component',['categories'=>$categories]);
//    }
//}


namespace App\Http\Livewire\Admin;

use App\Models\Category;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;
use function Symfony\Component\Translation\t;

class AdminEditProductComponent extends Component
{
    use WithFileUploads;

    public $product_id;
    public $name;
    public $slug;
    public $short_description;
    public $description;
    public $regular_price;
    public $sell_price;
    public $SKU;
    public $stock_status = 'instock';
    public $featured = 0;
    public $quantity;
    public $image;
    public $newimage;
    public $category_id;

    public function mount($product_id)
    {
        $product = Product::findOrFail($product_id);
        $this->product_id = $product->id;
        $this->name = $product->name;
        $this->slug = $product->slug;
        $this->short_description = $product->short_description;
        $this->description = $product->description;
        $this->regular_price = $product->regular_price;
        $this->sell_price = $product->sell_price;
        $this->SKU = $product->SKU;
        $this->stock_status = $product->stock_status;
        $this->featured = $product->featured;
        $this->quantity = $product->quantity;
        $this->image = $product->image;
        $this->category_id = $product->category_id;
    }

    public function generateSlug()
    {
        $this->slug = Str::slug($this->name);
    }

    public function updateProduct()
    {
        $this->validate([
            'name' => 'required',
            'slug' => 'required',
            'short_description' => 'required',
            'description' => 'required',
            'regular_price' => 'required',
            'sell_price' => 'required',
            'SKU' => 'required',
            'stock_status' => 'required',
            'featured' => 'nullable',
            'quantity' => 'required',
            'newimage' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:20000',
            'category_id' => 'required',
        ]);

        $product = Product::findOrFail($this->product_id);
        $product->name = $this->name;
        $product->slug = $this->slug;
        $product->short_description = $this->short_description;
        $product->description = $this->description;
        $product->regular_price = $this->regular_price;
        $product->sell_price = $this->sell_price;
        $product->SKU = $this->SKU;
        $product->stock_status = $this->stock_status;
        $product->featured = $this->featured;
        $product->quantity = $this->quantity;

        if ($this->newimage) {
            $extension = $this->newimage->extension();
            $fileName = date('ymdHis') . '.' . $extension;
            $this->newimage->storeAs('products', $fileName);
            $product->image = $fileName;
        }

        $product->category_id = $this->category_id;
        $product->save();

//        session()->flash('message', 'Product has been updated!');
        return redirect()->route('admin.products');
    }
    public function render()
    {
        $categories = Category::orderBy('name', 'ASC')->get();
        return view('livewire.admin.admin-edit-product-component', ['categories' => $categories]);
    }
}

