<?php

namespace App\Http\Controllers\RH;

use App\Http\Controllers\Controller;
use App\Models\JobOffer;
use Illuminate\Http\Request;

class JobOfferController extends Controller
{
    public function index()
    {
        $jobs = JobOffer::withCount('applications')->latest()->paginate(20);
        return view('rh.jobs.index', compact('jobs'));
    }

    public function create()
    {
        return view('rh.jobs.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'type'        => 'required|string|max:100',
            'location'    => 'required|string|max:255',
            'description' => 'required|string',
            'deadline'    => 'required|date|after:today',
            'is_active'   => 'boolean',
        ]);

        $data['is_active'] = $request->boolean('is_active');
        JobOffer::create($data);

        return redirect()->route('employee.rh.jobs.index')->with('success', 'Offre créée avec succès.');
    }

    public function edit(JobOffer $job)
    {
        return view('rh.jobs.edit', compact('job'));
    }

    public function update(Request $request, JobOffer $job)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'type'        => 'required|string|max:100',
            'location'    => 'required|string|max:255',
            'description' => 'required|string',
            'deadline'    => 'required|date',
            'is_active'   => 'boolean',
        ]);

        $data['is_active'] = $request->boolean('is_active');
        $job->update($data);

        return redirect()->route('employee.rh.jobs.index')->with('success', 'Offre mise à jour.');
    }

    public function destroy(JobOffer $job)
    {
        $job->delete();
        return redirect()->route('employee.rh.jobs.index')->with('success', 'Offre supprimée.');
    }
}
