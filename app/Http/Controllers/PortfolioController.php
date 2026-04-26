<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Project;
use App\Models\Skill;
use App\Models\Experience;
use App\Models\Contact;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    public function index()
    {
        $profile = Profile::first();
        $bestProjects = Project::best()->get();
        $otherProjects = Project::other()->get();
        $skills = Skill::where('is_active', true)->orderBy('sort_order')->get();
        $experiences = Experience::where('is_active', true)->orderBy('sort_order')->get();

        return view('portfolio', compact(
            'profile', 'bestProjects', 'otherProjects', 'skills', 'experiences'
        ));
    }

    public function sendContact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|max:2000',
        ]);

        Contact::create($validated);

        return back()->with('success', 'Message sent successfully! I will get back to you soon.');
    }
}
