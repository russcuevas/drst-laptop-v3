<?php

namespace App\Http\Controllers\staff;

use App\Http\Controllers\Controller;
use App\Models\Reports;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StaffAnalyticsController extends Controller
{
    public function AnalyticsPage()
    {
        if (Auth::check()) {
            if (Auth::user()->role !== 'staff') {
                return redirect()->route('loginpage');
            } else {
                return view('staff.analytics.staff_analytics');
            }
        }
        return redirect()->route('loginpage');
    }


    public function GetWeeklySales(Request $request)
    {
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

        return response()->json($weeklySales);
    }

    public function GetMonthlySales(Request $request)
    {
        $year = $request->input('year');

        $data = Reports::whereYear('receiving_date', $year)->get();

        $monthlySales = $data->groupBy(function ($item) {
            return Carbon::parse($item->receiving_date)->format('n');
        })->map(function ($group) {
            return $group->sum('total_amount');
        });

        return response()->json($monthlySales);
    }

    public function GetYearlySales()
    {
        try {
            $currentYear = date('Y');
            $startYear = 2020;

            $yearlySales = [];
            for ($year = $startYear; $year <= $currentYear; $year++) {
                $totalAmount = Reports::whereYear('receiving_date', $year)->sum('total_amount');
                $yearlySales[$year] = round($totalAmount, 2);
            }

            // response to be fetched in api
            return response()->json($yearlySales);
        } catch (\Exception $e) {
            // exception if error, display bad request
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }



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

        return response()->json($pie_chart_data);
    }

    public function GetComparisonSales(Request $request)
    {
        try {
            $yearSales = $request->input('yearSales');
            $yearComparison = $request->input('yearComparison');

            $salesYearData = Reports::whereYear('receiving_date', $yearSales)
                ->select(DB::raw('MONTH(receiving_date) as month'), DB::raw('SUM(total_amount) as total_sales'))
                ->groupBy(DB::raw('MONTH(receiving_date)'))
                ->pluck('total_sales', 'month')
                ->toArray();

            $comparisonYearData = Reports::whereYear('receiving_date', $yearComparison)
                ->select(DB::raw('MONTH(receiving_date) as month'), DB::raw('SUM(total_amount) as total_sales'))
                ->groupBy(DB::raw('MONTH(receiving_date)'))
                ->pluck('total_sales', 'month')
                ->toArray();

            $responseData = [];

            for ($month = 1; $month <= 12; $month++) {
                $monthSales = [
                    'sales' => isset($salesYearData[$month]) ? $salesYearData[$month] : 0,
                    'comparison' => isset($comparisonYearData[$month]) ? $comparisonYearData[$month] : 0
                ];
                $responseData[$month] = $monthSales;
            }

            return response()->json($responseData);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
