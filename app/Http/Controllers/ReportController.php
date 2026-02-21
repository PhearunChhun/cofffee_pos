<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use Carbon\Carbon;


class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Filter: date range
        $start = $request->start ? Carbon::parse($request->start)->startOfDay() : now()->startOfMonth();
        $end = $request->end ? Carbon::parse($request->end)->endOfDay() : now()->endOfMonth();

        $sales = Sale::with('items.product', 'user')
            ->whereBetween('created_at', [$start, $end])
            ->latest()
            ->get();

        // Total sales
        $totalSales = $sales->sum('total');

        return view('reports.index', compact('sales', 'totalSales', 'start', 'end'));
    }
   
}
