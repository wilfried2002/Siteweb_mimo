<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\JobOffer;
use App\Models\JobApplication;
use Illuminate\Http\Request;

class CareerController extends Controller
{
    /**
     * Liste des offres d'emploi actives.
     */
    public function index()
    {
        $jobs = JobOffer::active()->latest()->get();
        return view('frontend.careers.index', compact('jobs'));
    }

    /**
     * Détail d'une offre et formulaire de candidature.
     */
    public function show(JobOffer $jobOffer)
    {
        if (!$jobOffer->is_active || $jobOffer->is_expired) {
            abort(404);
        }
        return view('frontend.careers.show', compact('jobOffer'));
    }

    /**
     * Traiter la soumission d'une candidature liée à une offre.
     */
    public function apply(Request $request, JobOffer $jobOffer)
    {
        $validated = $request->validate([
            'first_name'   => ['required', 'string', 'max:100'],
            'last_name'    => ['required', 'string', 'max:100'],
            'email'        => ['required', 'email', 'max:255'],
            'phone'        => ['nullable', 'string', 'max:30'],
            'cover_letter' => ['nullable', 'string', 'max:3000'],
            'cv'           => ['required', 'file', 'mimes:pdf', 'max:5120'],
            'lettre'       => ['nullable', 'file', 'mimes:pdf', 'max:5120'],
        ], [
            'cv.required' => 'Le CV (PDF) est obligatoire.',
            'cv.mimes'    => 'Le CV doit être au format PDF uniquement.',
            'cv.max'      => 'Le CV ne doit pas dépasser 5 Mo.',
        ]);

        $cvPath     = $request->file('cv')->store('cvs', 'public');
        $lettrePath = $request->hasFile('lettre')
            ? $request->file('lettre')->store('lettres', 'public')
            : null;

        JobApplication::create([
            'job_offer_id' => $jobOffer->id,
            'first_name'   => $validated['first_name'],
            'last_name'    => $validated['last_name'],
            'email'        => $validated['email'],
            'phone'        => $validated['phone'] ?? null,
            'cover_letter' => $validated['cover_letter'] ?? null,
            'cv_path'      => $cvPath,
            'lettre_path'  => $lettrePath,
        ]);

        return redirect()->route('careers.index')
            ->with('success', 'Votre candidature a été envoyée avec succès ! Nous vous contacterons bientôt.');
    }

    /**
     * Candidature spontanée (sans offre spécifique).
     */
    public function applyOpen(Request $request)
    {
        $validated = $request->validate([
            'first_name'       => ['required', 'string', 'max:100'],
            'last_name'        => ['required', 'string', 'max:100'],
            'email'            => ['required', 'email', 'max:255'],
            'phone'            => ['nullable', 'string', 'max:30'],
            'desired_position' => ['nullable', 'string', 'max:255'],
            'cover_letter'     => ['nullable', 'string', 'max:3000'],
            'cv'               => ['required', 'file', 'mimes:pdf', 'max:5120'],
            'lettre'           => ['nullable', 'file', 'mimes:pdf', 'max:5120'],
        ]);

        $cvPath     = $request->file('cv')->store('cvs', 'public');
        $lettrePath = $request->hasFile('lettre')
            ? $request->file('lettre')->store('lettres', 'public')
            : null;

        JobApplication::create([
            'job_offer_id'     => null,
            'desired_position' => $validated['desired_position'] ?? null,
            'first_name'       => $validated['first_name'],
            'last_name'        => $validated['last_name'],
            'email'            => $validated['email'],
            'phone'            => $validated['phone'] ?? null,
            'cover_letter'     => $validated['cover_letter'] ?? null,
            'cv_path'          => $cvPath,
            'lettre_path'      => $lettrePath,
        ]);

        return redirect()->route('careers.index')
            ->with('success', 'Votre candidature spontanée a été envoyée ! Nous la transmettrons à notre équipe RH.');
    }
}
