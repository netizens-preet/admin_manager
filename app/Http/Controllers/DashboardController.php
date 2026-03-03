<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {

        $user = auth()->user();

        if ($user->isAdmin()) {
            // Admin Dashboard Data
            $totalProducts = Product::count();
            $totalOrders = Order::where('status', '!=', 'pending')->count();
            $totalRevenue = Order::where('status', 'delivered')->sum('total');
            $pendingOrders = Order::where('status', 'processing')->count();
            $totalCustomers = User::where('role', User::customer)->count();
            $recentOrders = Order::with('user')->where('status', '!=', 'pending')->latest()->take(5)->get();
            $recentProducts = Product::latest()->take(5)->get();
            $featuredInventory = Product::whereHas('tags', function ($q) {
                $q->where('product_tags.is_featured', true);
            })->with(['primaryimage', 'tags'])->latest()->take(5)->get();

            return view('dashboard', compact(
                'totalProducts',
                'totalOrders',
                'totalRevenue',
                'pendingOrders',
                'totalCustomers',
                'recentOrders',
                'recentProducts',
                'featuredInventory'
            ));
        } else {
            // Customer Dashboard Data
            $myOrdersCount = $user->orders()->where('status', '!=', 'pending')->count();
            $myTotalSpent = $user->orders()->where('status', 'delivered')->sum('total');

            $activeOrders = $user->orders()
                ->whereIn('status', ['processing', 'shipped'])
                ->with('items.product')
                ->latest()
                ->get();

            $recentMyOrders = $user->orders()
                ->where('status', '!=', 'pending')
                ->latest()
                ->take(5)
                ->get();

            $featuredProducts = Product::whereHas('tags', function ($q) {
                $q->where('is_featured', 1);
            })->with(['primaryimage', 'tags'])->where('is_active', 1)->latest()->take(4)->get();

            return view('dashboard', compact(
                'myOrdersCount',
                'myTotalSpent',
                'activeOrders',
                'recentMyOrders',
                'featuredProducts'
            ));
        }
    }
}
