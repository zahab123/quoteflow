<?php

namespace App\Http\Controllers;

use App\Models\Payment;

use Illuminate\Http\Request;
use App\Models\Quotations;

class DashboardController extends Controller
{
    // Show real time data on Dashboard
    public function index()
    {
        // every user separat data
        $userId = auth()->id(); 

        $totalQuotations    = Quotations::where('user_id', $userId)->count();
        $acceptedQuotations = Quotations::where('user_id', $userId)->where('status', 'accepted')->count();
        $declinedQuotations = Quotations::where('user_id', $userId)->where('status', 'declined')->count();
        $pendingQuotations  = Quotations::where('user_id', $userId)->whereIn('status', ['sent', 'draft'])->count();

        $totalRevenue = Quotations::where('user_id', $userId)
            ->where('status', 'accepted')
            ->sum('total');

        $totalPaid = Payment::whereHas('quotation', function ($q) use ($userId) {
                $q->where('user_id', $userId)->where('status', 'accepted');
            })
            ->sum('amount');

        $totalUnpaid = $totalRevenue - $totalPaid;

        $latestQuotations = Quotations::with('client')
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();


        $unpaidQuotations = Quotations::with('client')
            ->where('user_id', $userId)
            ->where('status', 'accepted')
            ->whereRaw('(total - (SELECT COALESCE(SUM(amount),0) 
                        FROM payments 
                        WHERE payments.quotation_id = quotations.id)) > 0')
            ->get();

        
        $monthlyData = Quotations::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->where('user_id', $userId)
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $monthlyRevenueData = Quotations::selectRaw('MONTH(created_at) as month, SUM(total) as revenue')
            ->where('user_id', $userId)
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
            'totalPaid',
            'totalUnpaid',
            'latestQuotations',
            'unpaidQuotations',   
            'monthlyLabels',
            'monthlyCounts',
            'monthlyRevenue'
        ));
    }
    // Real time data show in Report Page
    public function report()
    {
        $userId = auth()->id(); 

        // Counts
        $totalQuotations    = Quotations::where('user_id', $userId)->count();
        $acceptedQuotations = Quotations::where('user_id', $userId)->where('status', 'accepted')->count();
        $declinedQuotations = Quotations::where('user_id', $userId)->where('status', 'declined')->count();
        $pendingQuotations  = Quotations::where('user_id', $userId)->whereIn('status', ['sent', 'draft'])->count();

        
        $totalRevenue = Quotations::where('user_id', $userId)
            ->where('status', 'accepted')
            ->sum('total');

        
        $monthlyData = Quotations::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->where('user_id', $userId)
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        
        $monthlyRevenueData = Quotations::selectRaw('MONTH(created_at) as month, SUM(total) as revenue')
            ->where('user_id', $userId)
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