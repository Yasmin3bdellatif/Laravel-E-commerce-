<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Brand;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        // استلام المعلمات من الطلب
        $page = $request->query("page", 1);
        $size = $request->query("size", 12);
        $order = $request->query("order", -1);

        // استلام العلامات التجارية كقائمة مفصولة بفواصل وتحويلها إلى مصفوفة
        $q_brands = $request->query("brands", '');
        if ($q_brands) {
            $q_brands = explode(',', $q_brands);
        } else {
            $q_brands = []; // إذا كانت القيمة فارغة، اجعلها مصفوفة فارغة
        }

        // إعداد ترتيب المنتجات
        $o_column = "id";
        $o_order = "DESC";

        switch ($order) {
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

        // جلب العلامات التجارية
        $brands = Brand::orderBy("name", 'ASC')->get();

        // استعلام المنتجات مع الفلترة بناءً على العلامات التجارية
        $products = Product::when(!empty($q_brands), function ($query) use ($q_brands) {
            return $query->whereIn('brand_id', $q_brands);
        })
        ->orderBy($o_column, $o_order)
        ->paginate($size);

        // إرجاع العرض مع البيانات المطلوبة
        return view('shop', [
            'products' => $products,
            'page' => $page,
            'size' => $size,
            'order' => $order,
            'brands' => $brands,
            'q_brands' => $q_brands,
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
