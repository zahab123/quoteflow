<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quotations;

class DashboardController extends Controller
{
    // -------------------------
    // Dashboard method
    // -------------------------
    public function index()
    {
        // -------------------------
        // Stats for cards
        // -------------------------
        $totalQuotations    = Quotations::count();
        $acceptedQuotations = Quotations::where('status', 'accepted')->count();
        $declinedQuotations = Quotations::where('status', 'declined')->count();
        
        // Pending = sent but neither accepted nor declined
        $pendingQuotations  = Quotations::where('status', 'sent')->count();

        $totalRevenue       = Quotations::where('status', 'accepted')->sum('total');

        // -------------------------
        // Latest Quotations
        // -------------------------
        $latestQuotations = Quotations::with('client')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // -------------------------
        // Monthly data for charts
        // -------------------------
        $monthlyData = Quotations::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $monthlyRevenueData = Quotations::selectRaw('MONTH(created_at) as month, SUM(total) as revenue')
            ->whereYear('created_at', date('Y'))
            ->where('status', 'accepted')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $monthlyLabels  = [];
        $monthlyCounts  = [];
        $monthlyRevenue = [];

        for ($i = 1; $i <= 12; $i++) {
            $monthlyLabels[]  = date('M', mktime(0, 0, 0, $i, 1));
            $monthlyCounts[]  = $monthlyData->firstWhere('month', $i)->count ?? 0;
            $monthlyRevenue[] = $monthlyRevenueData->firstWhere('month', $i)->revenue ?? 0;
        }

        return view('admin.dashboard', compact(
            'totalQuotations',
            'acceptedQuotations',
            'pendingQuotations',
            'declinedQuotations',
            'totalRevenue',
            'latestQuotations',
            'monthlyLabels',
            'monthlyCounts',
            'monthlyRevenue'
        ));
    }

    // -------------------------
    // Report method
    // -------------------------
    public function report()
    {
        $totalQuotations    = Quotations::count();
        $acceptedQuotations = Quotations::where('status', 'accepted')->count();
        $declinedQuotations = Quotations::where('status', 'declined')->count();
        $pendingQuotations  = Quotations::where('status', 'sent')->count();
        $totalRevenue       = Quotations::where('status', 'accepted')->sum('total');

        // Monthly data for charts
        $monthlyData = Quotations::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $monthlyRevenueData = Quotations::selectRaw('MONTH(created_at) as month, SUM(total) as revenue')
            ->whereYear('created_at', date('Y'))
            ->where('status', 'accepted')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $monthlyLabels  = [];
        $monthlyCounts  = [];
        $monthlyRevenue = [];

        for ($i = 1; $i <= 12; $i++) {
            $monthlyLabels[]  = date('M', mktime(0, 0, 0, $i, 1));
            $monthlyCounts[]  = $monthlyData->firstWhere('month', $i)->count ?? 0;
            $monthlyRevenue[] = $monthlyRevenueData->firstWhere('month', $i)->revenue ?? 0;
        }

        return view('report', compact(
            'totalQuotations',
            'acceptedQuotations',
            'pendingQuotations',
            'declinedQuotations',
            'totalRevenue',
            'monthlyLabels',
            'monthlyCounts',
            'monthlyRevenue'
        ));
    }
}
