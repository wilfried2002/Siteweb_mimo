<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobOffer;
use Illuminate\Http\Request;

class JobOfferController extends Controller
{
    public function index()
    {
        $jobs = JobOffer::withCount('applications')->latest()->paginate(15);
        return view('admin.jobs.index', compact('jobs'));
    }

    public function create()
    {
        return view('admin.jobs.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'        => ['required', 'string', 'max:255'],
            'description'  => ['required', 'string'],
            'requirements' => ['nullable', 'string'],
            'location'     => ['required', 'string', 'max:100'],
            'type'         => ['required', 'in:CDI,CDD,Stage,Freelance,Temps partiel'],
            'deadline'     => ['required', 'date', 'after:today'],
            'is_active'    => ['boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        JobOffer::create($validated);

        return redirect()->route('admin.jobs.index')
            ->with('success', 'Offre d\'emploi créée avec succès.');
    }

    public function edit(JobOffer $job)
    {
        return view('admin.jobs.edit', compact('job'));
    }

    public function update(Request $request, JobOffer $job)
    {
        $validated = $request->validate([
            'title'        => ['required', 'string', 'max:255'],
            'description'  => ['required', 'string'],
            'requirements' => ['nullable', 'string'],
            'location'     => ['required', 'string', 'max:100'],
            'type'         => ['required', 'in:CDI,CDD,Stage,Freelance,Temps partiel'],
            'deadline'     => ['required', 'date'],
            'is_active'    => ['boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $job->update($validated);

        return redirect()->route('admin.jobs.index')
            ->with('success', 'Offre d\'emploi mise à jour avec succès.');
    }

    public function destroy(JobOffer $job)
    {
        $job->delete();
        return redirect()->route('admin.jobs.index')
            ->with('success', 'Offre d\'emploi supprimée avec succès.');
    }
}
