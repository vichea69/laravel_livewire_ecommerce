<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Livewire\WithPagination;
use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use HasFactory;
    public function category(){
        return $this->belongsTo(Category::class, 'category_id');
    }
}
