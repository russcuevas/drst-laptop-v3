<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Reports;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    public function ReportsPage()
    {
        if (Auth::check()) {
            if (Auth::user()->role !== 'admin') {
                return redirect()->route('loginpage');
            } else {
                $orderNotifications = DB::table('order_notifications')
                    ->join('orders', 'order_notifications.order_id', '=', 'orders.id')
                    ->select(
                        'orders.reference_number',
                        'orders.invoice_number',
                        'order_notifications.message',
                        DB::raw('MAX(orders.id) as order_id'),
                        DB::raw('MAX(order_notifications.created_at) as notification_created_at')
                    )
                    ->where('order_notifications.is_seen', false)
                    ->groupBy('orders.reference_number', 'orders.invoice_number', 'order_notifications.message')
                    ->orderBy('notification_created_at', 'desc')
                    ->get();

                $productNotifications = \App\Models\ProductNotifications::with('product')
                    ->where('is_seen', false)
                    ->orderBy('created_at', 'desc')
                    ->get();


                // Merge order and product notifications
                $notifications = $orderNotifications->merge($productNotifications);
                $reports = Reports::all();
                // returning the list of reports
                return view('admin.reports.admin_reports', compact('reports', 'notifications'));
            }
        }
    }

    public function DeleteReport($id)
    {
        if (Auth::check()) {
            if (Auth::user()->role !== 'admin') {
                return redirect()->route('loginpage');
            } else {
                $reports = Reports::find($id);
                if (!$reports) {
                    return redirect()->route('admin.reports')->with('error', 'Reports not found');
                } else {
                    $reports->delete();
                    return redirect()->route('admin.reports')->with('success', 'Reports deleted successfully');
                }
            }
        } else {
            return redirect()->route('loginpage');
        }
    }

    public function GenerateReports($type)
    {
        $reports = Reports::all();
        if ($type == 'pdf') {
            $pdf = PDF::loadView('admin.reports.reports_pdf', compact('reports'));

            return $pdf->download('reports.pdf');
        }
    }
}
