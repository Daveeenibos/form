<?php

namespace App\Http\Controllers;

use App\Models\Form;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $forms = $user->forms()->withCount('responses')->latest()->get();

        $stats = [
            'total_forms' => $forms->count(),
            'active_forms' => $forms->where('is_active', true)->count(),
            'total_responses' => $forms->sum('responses_count'),
        ];

        return view('dashboard', compact('forms', 'stats'));
    }
}
