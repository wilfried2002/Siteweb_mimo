<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ApplicationController extends Controller
{
    public function index()
    {
        $applications = JobApplication::with('jobOffer')->latest()->paginate(20);
        return view('admin.applications.index', compact('applications'));
    }

    public function show(JobApplication $application)
    {
        $application->load('jobOffer');
        return view('admin.applications.show', compact('application'));
    }

    public function updateStatus(Request $request, JobApplication $application)
    {
        $request->validate([
            'status' => ['required', 'in:pending,reviewed,accepted,rejected'],
        ]);

        $application->update(['status' => $request->status]);

        return back()->with('success', 'Statut de la candidature mis à jour.');
    }

    public function destroy(JobApplication $application)
    {
        // Supprimer le fichier CV
        if ($application->cv_path) {
            Storage::disk('public')->delete($application->cv_path);
        }
        $application->delete();

        return redirect()->route('admin.applications.index')
            ->with('success', 'Candidature supprimée avec succès.');
    }

    public function downloadCv(JobApplication $application)
    {
        $path = Storage::disk('public')->path($application->cv_path);

        if (!file_exists($path)) {
            return back()->with('error', 'Fichier CV introuvable.');
        }

        $filename = 'CV_' . $application->full_name . '_' . $application->id . '.pdf';
        return response()->download($path, $filename);
    }
}
