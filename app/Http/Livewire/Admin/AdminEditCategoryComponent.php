<?php

namespace App\Http\Livewire\Admin;

use App\Models\Category;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class AdminEditCategoryComponent extends Component
{
    use WithFileUploads;
    public $category_id;
    public $name;
    public $slug;
    public $image;
    public $is_popular = 0;
    public $newimage;

    public function mount()
    {
        $category = Category::find($this->category_id);
        $this->name = $category->name;
        $this->slug = $category->slug;
        $this->image =$category->image;
        $this->is_popular =$category->is_popular;
    }

    public function generateSlug()
    {
        $this->slug = Str::slug($this->name);
    }

    public function update($fields)
    {
        $this->validateOnly($fields, [
            'name' => 'required',
            'slug' => 'required'
        ]);
    }

    public function updateCategory()
    {
        $this->validate([
            'name' => 'required',
            'slug' => 'required'
        ]);

        $category = Category::find($this->category_id);
        $category->name = $this->name;
        $category->slug = $this->slug;
        if ($this->newimage) {
            $extension = $this->newimage->extension();
            $fileName = date('ymdHis') . '.' . $extension;
            $this->newimage->storeAs('categories', $fileName);
            $category->image = $fileName;
        }
        $category->is_popular =$this->is_popular;
        $category->save();
        return redirect()->route('admin.categories');
//        session()->flash('message', 'Category has been updated');
    }


    public function render()
    {
        return view('livewire.admin.admin-edit-category-component', ['category_id' => $this->category_id]);
    }
}
