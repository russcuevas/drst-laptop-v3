<?php

namespace App\Http\Controllers\staff;

use App\Http\Controllers\Controller;
use App\Models\Reports;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class StaffReportsController extends Controller
{
    public function ReportsPage()
    {
        if (Auth::check()) {
            if (Auth::user()->role !== 'staff') {
                return redirect()->route('loginpage');
            } else {
                $reports = Reports::all();
                // returning the list of reports
                return view('staff.reports.staff_reports', compact('reports'));
            }
        }
    }

    public function GenerateReports($type)
    {
        $reports = Reports::all();
        if ($type == 'pdf') {
            $pdf = PDF::loadView('staff.reports.reports_pdf', compact('reports'));

            return $pdf->download('reports.pdf');
        }
    }
}
