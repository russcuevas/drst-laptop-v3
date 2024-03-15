<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Reports;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportsController extends Controller
{
    public function ReportsPage()
    {
        if (Auth::check()) {
            if (Auth::user()->role !== 'admin') {
                return redirect()->route('loginpage');
            } else {
                $reports = Reports::all();
                // returning the list of reports
                return view('admin.reports.admin_reports', compact('reports'));
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
