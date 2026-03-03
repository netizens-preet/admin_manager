<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Fetch the data once here
        $totalProducts = Product::count();
        $totalOrders   = Order::count();
        $totalRevenue  = Order::where('status', 'delivered')->sum('total');
        $pendingOrders = Order::where('status', 'pending')->count();

        // Pass it to the 'dashboard' view
        return view('dashboard', compact(
            'totalProducts',
            'totalOrders',
            'totalRevenue',
            'pendingOrders'
        ));
    }
}
