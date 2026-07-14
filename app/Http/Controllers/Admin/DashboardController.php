<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Project;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard', [
            'projectCount' => Project::count(),
            'experienceCount' => Experience::count(),
            'educationCount' => Education::count(),
            'messageCount' => ContactMessage::count(),
            'latestMessages' => ContactMessage::latest()->take(5)->get(),
        ]);
    }
}
