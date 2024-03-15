<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Reports;
use App\Models\TopProducts;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    // display analytics page
    public function AnalyticsPage()
    {
        // check if the role is admin or not
        if (Auth::check()) {
            // if not it will redirect to loginpage
            if (Auth::user()->role !== 'admin') {
                return redirect()->route('loginpage');
            } else {
                // else it will go to analytics page
                return view('admin.analytics.admin_analytics');
            }
        }
        // else not authenticated it will navigate to loginpage
        return redirect()->route('loginpage');
    }


    // displaying weekly sales
    public function GetWeeklySales(Request $request)
    {
        // if it is set in the selected year and month it will update dynamically
        $year = $request->input('year');
        $month = $request->input('month');

        $data = Reports::whereYear('receiving_date', $year)
            ->whereMonth('receiving_date', $month)
            ->get();

        $weeklySales = $data->groupBy(function ($item) {
            return Carbon::parse($item->receiving_date)->week;
        })->map(function ($group) {
            return $group->sum('total_amount');
        });
        // response to be fetch in api
        return response()->json($weeklySales);
    }

    public function GetMonthlySales(Request $request)
    {
        // if it is set in the month it will update dynamically
        $year = $request->input('year');

        $data = Reports::whereYear('receiving_date', $year)->get();

        $monthlySales = $data->groupBy(function ($item) {
            return Carbon::parse($item->receiving_date)->format('n');
        })->map(function ($group) {
            return $group->sum('total_amount');
        });

        // response to be fetch in api
        return response()->json($monthlySales);
    }

    // display yearly sales
    public function GetYearlySales()
    {
        try {
            $allYears = Reports::distinct()
                ->selectRaw('YEAR(receiving_date) as year')
                ->pluck('year');

            $yearlySales = $allYears->map(function ($year) {
                $totalAmount = Reports::whereYear('receiving_date', $year)->sum('total_amount');
                return [$year => round($totalAmount, 2)];
            })->reduce(function ($carry, $item) {
                return $carry->merge($item);
            }, collect());

            // response to be fetch in api
            return response()->json($yearlySales);
        } catch (\Exception $e) {
            // execeiiption if error display bad request
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // display top products
    public function GetTopProducts()
    {
        $top_products = DB::table('top_products')
            ->join('products', 'top_products.product_id', '=', 'products.id')
            ->select('products.product_name', 'top_products.total_sold')
            ->orderBy('top_products.total_sold', 'desc')
            ->take(3)
            ->get();

        $pie_chart_data = $top_products->map(function ($product) {
            return [
                'product_name' => $product->product_name,
                'total_sold' => $product->total_sold,
            ];
        });
        
        // response to be fetch in api
        return response()->json($pie_chart_data);
    }
}
