<?php

namespace App\Http\Livewire\Admin;

use App\Models\Category;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class AdminAddCategorycomponent extends Component
{
    use WithFileUploads;
    public $name;
    public $slug;
    public $image;
    public $is_popular = 0;
    public function generateSlug(){
        $this->slug = Str::slug($this->name);
    }
    public function update($fields){
        $this->validateOnly($fields,[
            'name'=>'required',
            'slug'=>'required',
            'image'=>'required|image|mimes:jpg,png,jpeg,gif|max:20000'
        ]);
    }
    public function storeCategory(){
        $this->validate([
            'name'=>'required',
            'slug'=>'required',
            'image'=>'required|image|mimes:jpg,png,jpeg,gif|max:20000'
        ]);
        $category = new Category();
        $category ->name =$this->name;
        $category->slug = $this->slug;
        if ($this->image) {
            $extension = $this->image->extension();
            $fileName = date('ymdHis') . '.' . $extension;
            $this->image->storeAs('categories', $fileName);
            $category->image = $fileName;
        }
        $category->is_popular = $this->is_popular;
        $category->save();
        return redirect()->route('admin.categories');
//        session()->flash('message','Category Has been Add');
    }
    public function render()
    {

        return view('livewire.admin.admin-add-categorycomponent');
    }
}
