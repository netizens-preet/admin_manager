<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Order;
use App\Models\User;

class DashboardService
{
    /**
     * Get data specifically for the Admin View
     */
    public function getAdminStats()
    {
        return [
            'totalProducts' => Product::count(),
            'totalOrders' => Order::where('status', '!=', 'pending')->count(),
            'totalRevenue' => Order::where('status', 'delivered')->sum('total'),
            'pendingOrders' => Order::where('status', 'processing')->count(),
            'totalCustomers' => User::where('role', User::ROLE_CUSTOMER)->count(),
            'recentOrders' => Order::with('user')->where('status', '!=', 'pending')->latest()->take(5)->get(),
            'recentProducts' => Product::latest()->take(5)->get(),
            'featuredInventory' => Product::whereHas('tags', fn($q) => $q->where('product_tags.is_featured', true))
                ->with(['primaryimage', 'tags'])
                ->latest()
                ->take(5)
                ->get(),
        ];
    }

    /**
     * 
     * Get data specifically for the Customer View
     */
    public function getCustomerStats($user)
    {
        return [
            'myOrdersCount' => $user->orders()->where('status', '!=', 'pending')->count(),
            'myTotalSpent' => $user->orders()->where('status', 'delivered')->sum('total'),
            'activeOrders' => $user->orders()
                ->whereIn('status', ['processing', 'shipped'])
                ->with('items.product')
                ->latest()
                ->get(),
            'recentMyOrders' => $user->orders()
                ->where('status', '!=', 'pending')
                ->latest()
                ->take(5)
                ->get(),
            'featuredProducts' => Product::whereHas('tags', fn($q) => $q->where('is_featured', 1))
                ->with(['primaryimage', 'tags'])
                ->where('is_active', 1)
                ->latest()
                ->take(4)
                ->get(),
        ];
    }
}