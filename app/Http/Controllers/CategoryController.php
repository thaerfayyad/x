<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class CategoryController extends Controller
{
    function all()
    {
        return Category::all();
    }

    function category($id = null)
    {
        return $id ? Category::find($id) : Category::all();//If and Else  if find category with this id get it else get all categories
    }

    function add(Request $request)
    {
        /*$data = array();
        $data['category_name'] = $request->category_name;
        $data['user_id'] = Auth::user()->id;
        $data['created_at'] = Carbon::now();
        DB::table('categories')->insert($data);*/
        $category = new Category();
        $category->name = $request->name;
        $category->description = $request->description;
        $category->image = $request->image;
        $category->statuss = $request->statuss;
        $category->date_of_create = Carbon::now();
        $result = $category->save();
        if ($result)
            return ["Result" => "Category added Successfully"];
        else
            return ["Result" => "Failed to add"];
    }

    function edit(Request $request, $id)
    {
        $category = Category::find($id);
        $category->name = $request->name;
        $category->description = $request->description;
        $category->image = $request->image;
        $category->statuss = $request->statuss;
        $category->date_of_create = Carbon::now();
        $result = $category->save();
        if ($result)
            return ["Result" => "Category update Successfully"];
        else
            return ["Result" => "Failed to update"];
    }

    function search($string){
        return Category::where("name", "like","%".$string."%")->get();
    }

    function delete($id){
        $delete = Category::find($id)->delete();
        if($delete)
            return ["Result" => "Category delete Successfully"];
        else
            return ["Result" => "Failed to delete"];
    }

    public function forceDelete($id)
    {
        $forceDelete = Category::onlyTrashed()->find($id)->forceDelete();
        return Redirect::back()->with('successUpdate','Successfully Soft Delete Category');
    }

    public function restoreCat($id)
    {
        $restore = Category::withTrashed()->find($id)->restore();
        return Redirect::back()->with('successUpdate','Successfully Force Restore Category');
    }

}
