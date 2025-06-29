<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Payment;
use App\Models\Blog;
use App\Models\Eduwisata;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Today's statistics
        $today = Carbon::today();
        $todayOrders = Order::whereDate('created_at', $today)->count();
        $todayRevenue = Order::whereDate('created_at', $today)
            ->where('status', 'selesai')
            ->sum('total_harga');
        $todayCustomers = Customer::whereDate('created_at', $today)->count();

        // This month's statistics
        $thisMonth = Carbon::now()->startOfMonth();
        $monthlyOrders = Order::where('created_at', '>=', $thisMonth)->count();
        $monthlyRevenue = Order::where('created_at', '>=', $thisMonth)
            ->where('status', 'selesai')
            ->sum('total_harga');
        $monthlyCustomers = Customer::where('created_at', '>=', $thisMonth)->count();

        // Top selling products
        $topProducts = Product::withCount(['orderItems as total_sold' => function($query) {
            $query->select(DB::raw('SUM(quantity)'));
        }])
        ->orderBy('total_sold', 'desc')
        ->take(5)
        ->get();

        // Recent orders
        $recentOrders = Order::with(['produk', 'eduwisata', 'orderItems.product'])
            ->latest()
            ->take(10)
            ->get();

        // Payment statistics
        $paymentStats = Payment::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get();

        // Low stock products
        $lowStockProducts = Product::where('stock', '<=', 10)
            ->orderBy('stock', 'asc')
            ->take(5)
            ->get();

        // Stock analytics
        $stockAnalytics = [
            'total_products' => Product::count(),
            'low_stock' => Product::where('stock', '<=', 10)->count(),
            'out_of_stock' => Product::where('stock', '<=', 0)->count(),
            'total_stock_value' => Product::sum(DB::raw('stock * price')),
        ];

        // Monthly revenue chart data
        $monthlyRevenueData = Order::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('SUM(total_harga) as revenue')
        )
        ->where('status', 'selesai')
        ->whereYear('created_at', Carbon::now()->year)
        ->groupBy('month')
        ->orderBy('month')
        ->get();

        // Order status distribution
        $orderStatusData = Order::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get();

        return view('dashboard.index', compact(
            'todayOrders',
            'todayRevenue',
            'todayCustomers',
            'monthlyOrders',
            'monthlyRevenue',
            'monthlyCustomers',
            'topProducts',
            'recentOrders',
            'paymentStats',
            'lowStockProducts',
            'stockAnalytics',
            'monthlyRevenueData',
            'orderStatusData'
        ));
    }

    public function analytics()
    {
        // Sales analytics
        $salesData = Order::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as orders'),
            DB::raw('SUM(total_harga) as revenue')
        )
        ->where('created_at', '>=', Carbon::now()->subDays(30))
        ->groupBy('date')
        ->orderBy('date')
        ->get();

        // Product performance
        $productPerformance = Product::withCount(['orderItems as total_orders' => function($query) {
            $query->select(DB::raw('COUNT(DISTINCT order_id)'));
        }])
        ->withSum(['orderItems as total_revenue' => function($query) {
            $query->select(DB::raw('SUM(subtotal)'));
        }])
        ->orderBy('total_revenue', 'desc')
        ->take(10)
        ->get();

        // Customer analytics
        $customerAnalytics = Customer::withCount('orders')
            ->withSum('orders as total_spent')
            ->orderBy('total_spent', 'desc')
            ->take(10)
            ->get();

        return view('dashboard.analytics', compact(
            'salesData',
            'productPerformance',
            'customerAnalytics'
        ));
    }

    public function reports()
    {
        $startDate = request('start_date', Carbon::now()->startOfMonth());
        $endDate = request('end_date', Carbon::now()->endOfMonth());

        // Sales report
        $salesReport = Order::with(['produk', 'eduwisata', 'orderItems.product'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get()
            ->groupBy(function($order) {
                return $order->created_at->format('Y-m-d');
            });

        // Product sales report
        $productSalesReport = Product::withCount(['orderItems as total_orders' => function($query) use ($startDate, $endDate) {
            $query->whereHas('order', function($q) use ($startDate, $endDate) {
                $q->whereBetween('created_at', [$startDate, $endDate]);
            });
        }])
        ->withSum(['orderItems as total_revenue' => function($query) use ($startDate, $endDate) {
            $query->whereHas('order', function($q) use ($startDate, $endDate) {
                $q->whereBetween('created_at', [$startDate, $endDate]);
            });
        }])
        ->orderBy('total_revenue', 'desc')
        ->get();

        return view('dashboard.reports', compact(
            'salesReport',
            'productSalesReport',
            'startDate',
            'endDate'
        ));
    }
}
