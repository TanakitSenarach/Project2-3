<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $category = category::orderby('category_id','desc')->Paginate(5);
        return view('backend.category.index',compact('category'));
    }

    public function createfrom()
    {
        return view('backend.category.createfrom');
    }


    public function insert(Request $request)
    {

//ทำการป้องกันการกรอกข้อมูลผ่านฟอร์ม
$validated = $request->validate([
    'name' => 'required|unique:categories|max:255',
],
[
    'name.required' => "กรุณากรอกชื่อประเภทสินค้า",
    'name.unique' => "ชื่อนี้มีอยู่ในฐานข้อมูลแล้ว",
    'name.max' => "กรอกข้อมูลไม่เกิน 255 ตัวอักษร",
]);

//การบันทึกข้อมูลลงในฐานข้อมูล
        $category = new Category();
        $category->name = $request->name;
        $category->save();
        alert()->success('บันทึกข้อมูลสำเร็จ','ชื่อประเภทสินค้าชื่อนี้ถูกบันทึกลงในฐานข้อมูลเรียบร้อยแล้ว');
        return redirect('admin/category/index');
    }

    public function edit($category_id){
        $category = Category::find($category_id);
        return view('backend.category.edit',compact('category'));

    }

    public function update(Request $request, $category_id){
        $category = Category::find($category_id);
        $category -> name = $request->name;
        $category -> update();
        alert()->success('อัพเดทข้อมูลสำเร็จ','ชื่อประเภทสินค้าชื่อนี้ถูกบันทึกลงในฐานข้อมูลเรียบร้อยแล้ว');
        return redirect('admin/category/index');
    }

    public function delete($category_id){
        $category = Category::find($category_id);
        $category ->delete();
        alert()->success('ลบข้อมูลสำเร็จ','ข้อมูลนี้ลบเรียบร้อยแล้ว');
        return redirect('admin/category/index');
}

}