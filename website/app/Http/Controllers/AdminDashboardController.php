<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Get count of pending bookings
        $pendingBookingsCount = Booking::where('status', 'pending')->count();
        
        // You can also get other statistics if needed
        $totalBookings = Booking::count();
        $approvedBookings = Booking::where('status', 'approved')->count();
        $rejectedBookings = Booking::where('status', 'rejected')->count();
        
        return view('admin.dashboard', compact(
            'pendingBookingsCount',
            'totalBookings',
            'approvedBookings',
            'rejectedBookings'
        ));
    }
}