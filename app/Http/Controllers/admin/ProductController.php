<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Categoryt;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use File;
use Image;


class ProductController extends Controller
{
    public function index()
    {
        $product = Product::orderBy('created_at','desc')->Paginate();
        return view('backend.product.index',compact('product'));
    }

    public function createfrom()
    {
        $category = Category::all();
        return view('backend.product.createfrom');
    }

    public function edit($product_id)
    {
        $pro = Product::find($product_id);
        $cat = category::all();
        return view('backend.product.edit');
    }

    public function insert(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required|max:255',
            'price' => 'required|max:255',
            'description' => 'required',
            'image' => 'mimes:png,jpg,jpeg',
        ],[
            'name.required' => 'กรุณากรอกข้อมูลชื่อสินค้า',
            'name.max' => 'กรอกข้อมูลได้สูงสุด 255 ตัวอักษร',
            'price.required' => 'กรุณากรอกข้อมูลราคาสินค้า',
            'price.max' => 'กรอกข้อมูลได้สูงสุด 255 ตัวอักษร',
            'description' => 'กรุณากรอกข้อมูลรายละเอียดสินค้า',
            'image.mimes' => 'อัพโหลดภาพที่มีนามสกุล .jpg .png .jpeg ได้เท่านั้น',

        ])
        ;

        $pro = new Product();
        $pro->name = $request->name;
        $pro->price = $request->price;
        $pro->description = $request->description;
        $pro->category_id = $request->category_id;
        if($request->hasFile('image')){
            $filename = Str::random(10). '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path().'/backend/product/',$filename);
            Image::make(public_path().'/backend/product/'.$filename)->resize(200,200)->save(public_path().'/backend/product/resize/'.$filename);
            $pro->image = $filename;

        }else{
            $pro->image = "no_image.jpg";
        }
        $pro->save();
        alert()->success('แก้ไขข้อมูลสำเร็จ','ข้อมูลนี้ถูกบันทึกแล้ว');
        return redirect('admin/product/index');
    }

  
    public function update(Request $request, $product_id){
        $pro = Product::find($product_id);


    $pro->name = $request->name;
        $pro->price = $request->price;
        $pro->description = $request->description;
        $pro->category_id = $request->category_id;
        if($request->hasFile('image')){
            if($pro->image != 'no_image.jpg'){
                File::delete(public_path().'/backend/product/'.$pro->image);
                File::delete(public_path().'/backend/resize/'.$pro->image);
            }
            $filename = Str::random(10). '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path().'/backend/product/',$filename);
            Image::make(public_path().'/backend/product/'.$filename)->resize(200,200)->save(public_path().'/backend/product/resize/'.$filename);
            $pro->image = $filename;

        }

        $pro->update();
        alert()->success('แก้ไขข้อมูลสำเร็จ','ข้อมูลนี้ถูกอัพเดทแล้ว');
        return redirect('admin/product/index');
    }

        public function delete($product_id){
            $pro = Product::find($product_id);
            if($pro->image != 'no_image.jpg'){
                File::delete(public_path().'/backend/product/'.$pro->image);
                File::delete(public_path().'/backend/resize/'.$pro->image);
        }
        $pro->delete();
        alert()->success('ลบข้อมูลสำเร็จ','ข้อมูลนี้ถูกลบแล้ว');
        return redirect('admin/product/index');
  }
}
