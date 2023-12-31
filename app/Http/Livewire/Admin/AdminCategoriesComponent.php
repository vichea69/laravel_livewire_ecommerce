<?php

namespace App\Http\Livewire\Admin;

use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;
class AdminCategoriesComponent extends Component
{
    public $category_id;
    use WithPagination;
    public function deleteCategory($category_id)
    {
        $category = Category::where('id',$category_id)->first();
        $category->delete();
        return redirect()->route('admin.categories');
//        session()->flash('message', 'Category has been deleted!');
    }
    public function render()
    {
        $categories = Category::orderBy('name','ASC')->paginate(5);
        return view('livewire.admin.admin-categories-component',['categories'=>$categories]);
    }
}
//}



