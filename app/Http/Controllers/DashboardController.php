<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quotations;

class DashboardController extends Controller
{
    public function index()
    {
        // -------------------------
        // Total quotations
        // -------------------------
        $totalQuotations = Quotations::count();
        $acceptedQuotations = Quotations::where('status', 'accepted')->count();
        $pendingQuotations  = Quotations::where('status', 'pending')->count();
        $declinedQuotations = Quotations::where('status', 'declined')->count();

        // -------------------------
        // Total revenue
        // -------------------------
        $totalRevenue = Quotations::sum('total');

        // -------------------------
        // Latest 5 quotations
        // -------------------------
        $latestQuotations = Quotations::with('client')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // -------------------------
        // Monthly quotation counts
        // -------------------------
        $monthlyData = Quotations::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $monthlyLabels = [];
        $monthlyCounts = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthlyLabels[] = date('M', mktime(0, 0, 0, $i, 1));
            $monthlyCounts[] = $monthlyData->firstWhere('month', $i)->count ?? 0;
        }

        // -------------------------
        // Monthly revenue trend
        // -------------------------
        $monthlyRevenueData = Quotations::selectRaw('MONTH(created_at) as month, SUM(total) as revenue')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $monthlyRevenue = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthlyRevenue[] = $monthlyRevenueData->firstWhere('month', $i)->revenue ?? 0;
        }

        // -------------------------
        // Pass data to view
        // -------------------------
        return view('admin.dashboard', compact(
            'totalQuotations',
            'acceptedQuotations',
            'pendingQuotations',
            'declinedQuotations',
            'totalRevenue',
            'latestQuotations',
            'monthlyLabels',
            'monthlyCounts',
            'monthlyRevenue' // for revenue trend chart
        ));
    }
}
