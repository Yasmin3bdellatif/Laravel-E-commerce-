<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ShopController extends Controller
{
    public function index(Request $request)
    {       
        // استرداد القيم من الاستعلام
        $page = $request->query("page", 1);
        $size = $request->query("size", 12);
        $order = $request->query("order", -1);

        // تحديد العمود والاتجاه حسب ترتيب المستخدم
        $o_column = "id";
        $o_order = "DESC";

        switch($order)
        {
            case 1:
                $o_column = "created_at";
                $o_order = "DESC";
                break;
            case 2:
                $o_column = "created_at";
                $o_order = "ASC";
                break;
            case 3:
                $o_column = "regular_price";
                $o_order = "ASC";
                break;  
            case 4:
                $o_column = "regular_price";
                $o_order = "DESC";
                break;
        }

        // استعلام المنتجات مع الترتيب
        $products = Product::orderBy($o_column, $o_order)->paginate($size);

        // إعادة عرض المنتجات
        return view('shop', [
            'products' => $products,
            'page' => $page,
            'size' => $size,
            'order' => $order
        ]);
    }   

    public function productDetails($slug)
    {
        $product = Product::where('slug', $slug)->first();
        $rproducts = Product::where('slug', '!=', $slug)
            ->inRandomOrder() 
            ->take(8) 
            ->get();
        return view('details', [
            'product' => $product,
            'rproducts' => $rproducts
        ]);
    }
}
