<?php

namespace App\Http\Controllers\RH;

use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ApplicationController extends Controller
{
    public function index(Request $request)
    {
        $query = JobApplication::with('jobOffer')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('first_name', 'like', "%{$request->search}%")
                  ->orWhere('last_name', 'like', "%{$request->search}%")
                  ->orWhere('email', 'like', "%{$request->search}%");
            });
        }

        $applications = $query->paginate(20)->withQueryString();
        $stats = [
            'pending'  => JobApplication::where('status', 'pending')->count(),
            'reviewed' => JobApplication::where('status', 'reviewed')->count(),
            'accepted' => JobApplication::where('status', 'accepted')->count(),
            'rejected' => JobApplication::where('status', 'rejected')->count(),
        ];

        return view('rh.applications.index', compact('applications', 'stats'));
    }

    public function show(JobApplication $application)
    {
        $application->load('jobOffer');

        // Auto-mark as reviewed when opened
        if ($application->status === 'pending') {
            $application->update(['status' => 'reviewed']);
        }

        return view('rh.applications.show', compact('application'));
    }

    public function updateStatus(Request $request, JobApplication $application)
    {
        $request->validate([
            'status' => 'required|in:pending,reviewed,accepted,rejected',
        ]);
        $application->update(['status' => $request->status]);
        return back()->with('success', 'Statut mis à jour.');
    }

    public function downloadCv(JobApplication $application)
    {
        if (!$application->cv_path || !Storage::disk('public')->exists($application->cv_path)) {
            return back()->with('error', 'Fichier CV introuvable.');
        }
        return Storage::disk('public')->download($application->cv_path,
            "CV_{$application->full_name}.pdf");
    }

    public function downloadLettre(JobApplication $application)
    {
        if (!$application->lettre_path || !Storage::disk('public')->exists($application->lettre_path)) {
            return back()->with('error', 'Lettre de motivation introuvable.');
        }
        return Storage::disk('public')->download($application->lettre_path,
            "Lettre_{$application->full_name}.pdf");
    }

    public function destroy(JobApplication $application)
    {
        if ($application->cv_path) Storage::disk('public')->delete($application->cv_path);
        if ($application->lettre_path) Storage::disk('public')->delete($application->lettre_path);
        $application->delete();
        return redirect()->route('employee.rh.applications.index')->with('success', 'Candidature supprimée.');
    }
}
