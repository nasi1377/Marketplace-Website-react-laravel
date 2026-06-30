<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Pcategory;
use App\Models\Product;
use App\Models\HairstylistService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use TCG\Voyager\Models\Menu;


class HomeController extends Controller
{
    public function index()
    {
        try {

            // محصولات منتشر شده
            $products = Product::where('status', 'PUBLISHED')
                ->latest()
                ->take(8)
                ->get();

            // دسته بندی ها
            $categories = Pcategory::orderBy('order', 'DESC')
                ->get();

            // خدمات آرایشگران تایید شده
            $stylistPosts = HairstylistService::with('user')
                ->where('status', 'approved')
                ->latest()
                ->get();

            // دوره های تایید شده
            $courses = Course::where('status', 'publish')
                ->latest()
                ->get();

            return response()->json([
                'success' => true,
                'data' => [
                    'products' => $products,
                    'stylistPosts' => $stylistPosts,
                    'categories' => $categories,
                    'courses' => $courses,
                ]
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);

        }
    }


public function menus()
{
    $menu = Menu::with('items')
        ->where('id', 2)
        ->first();

    return response()->json($menu->items);
}

public function footerData()
{
    $settings = DB::table('settings')->pluck('value', 'key');

    return response()->json([
        'description' => $settings['footer.description'] ?? '',
        'phone'       => $settings['contact.phone'] ?? '',
        'email'       => $settings['contact.email'] ?? '',
        'address'     => $settings['contact.address'] ?? '',
        'instagram'   => $settings['social.instagram'] ?? '',
        'enamad'      => $settings['footer.enamad'] ?? '',
        'logo'        => isset($settings['site.logo'])
            ? asset('storage/' . $settings['site.logo'])
            : null,
    ]);
}
}