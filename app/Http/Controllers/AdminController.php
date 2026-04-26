<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Project;
use App\Models\Skill;
use App\Models\Experience;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    // ─── Dashboard ─────────────────────────────────────────
    public function dashboard()
    {
        $stats = [
            'projects' => Project::count(),
            'skills' => Skill::count(),
            'experiences' => Experience::count(),
            'messages' => Contact::count(),
            'unread' => Contact::where('is_read', false)->count(),
        ];
        $recentMessages = Contact::latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentMessages'));
    }

    // ─── Profile ───────────────────────────────────────────
    public function profile()
    {
        $profile = Profile::first();
        return view('admin.profile', compact('profile'));
    }

    public function updateProfile(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'short_name' => 'required|string|max:100',
            'title' => 'required|string|max:255',
            'bio' => 'required|string',
            'quote' => 'nullable|string|max:500',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'location' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'social_links' => 'nullable|array',
        ]);

        $profile = Profile::first();

        if ($request->hasFile('photo')) {
            if ($profile->photo) {
                Storage::disk('public')->delete($profile->photo);
            }
            $validated['photo'] = $request->file('photo')->store('profile', 'public');
        }

        $profile->update($validated);

        return back()->with('success', 'Profile updated successfully!');
    }

    // ─── Projects ──────────────────────────────────────────
    public function projects()
    {
        $projects = Project::orderBy('category')->orderBy('sort_order')->get();
        return view('admin.projects.index', compact('projects'));
    }

    public function createProject()
    {
        return view('admin.projects.form', ['project' => new Project()]);
    }

    public function storeProject(Request $request)
    {
        $validated = $this->validateProject($request);

        if ($request->hasFile('screenshot')) {
            $validated['screenshot'] = $request->file('screenshot')->store('projects', 'public');
        }

        Project::create($validated);

        return redirect('/admin/projects')->with('success', 'Project created successfully!');
    }

    public function editProject(Project $project)
    {
        return view('admin.projects.form', compact('project'));
    }

    public function updateProject(Request $request, Project $project)
    {
        $validated = $this->validateProject($request);

        if ($request->hasFile('screenshot')) {
            if ($project->screenshot) {
                Storage::disk('public')->delete($project->screenshot);
            }
            $validated['screenshot'] = $request->file('screenshot')->store('projects', 'public');
        }

        $project->update($validated);

        return redirect('/admin/projects')->with('success', 'Project updated successfully!');
    }

    public function deleteProject(Project $project)
    {
        if ($project->screenshot) {
            Storage::disk('public')->delete($project->screenshot);
        }
        $project->delete();

        return redirect('/admin/projects')->with('success', 'Project deleted successfully!');
    }

    private function validateProject(Request $request): array
    {
        return $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'screenshot' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'icon' => 'nullable|string|max:50',
            'icon_color' => 'nullable|string|max:20',
            'demo_url' => 'nullable|url|max:255',
            'repo_url' => 'nullable|url|max:255',
            'category' => 'required|in:best,other',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);
    }

    // ─── Skills ────────────────────────────────────────────
    public function skills()
    {
        $skills = Skill::orderBy('category')->orderBy('sort_order')->get();
        return view('admin.skills', compact('skills'));
    }

    public function storeSkill(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'icon' => 'nullable|string|max:50',
            'category' => 'nullable|string|max:100',
            'level' => 'required|integer|min:0|max:100',
            'sort_order' => 'nullable|integer',
        ]);

        Skill::create($validated);

        return back()->with('success', 'Skill added successfully!');
    }

    public function updateSkill(Request $request, Skill $skill)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'icon' => 'nullable|string|max:50',
            'category' => 'nullable|string|max:100',
            'level' => 'required|integer|min:0|max:100',
            'sort_order' => 'nullable|integer',
        ]);

        $skill->update($validated);

        return back()->with('success', 'Skill updated successfully!');
    }

    public function deleteSkill(Skill $skill)
    {
        $skill->delete();
        return back()->with('success', 'Skill deleted successfully!');
    }

    // ─── Experiences ───────────────────────────────────────
    public function experiences()
    {
        $experiences = Experience::orderBy('sort_order')->get();
        return view('admin.experiences', compact('experiences'));
    }

    public function storeExperience(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'period' => 'required|string|max:100',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer',
        ]);

        Experience::create($validated);

        return back()->with('success', 'Experience added successfully!');
    }

    public function updateExperience(Request $request, Experience $experience)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'period' => 'required|string|max:100',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer',
        ]);

        $experience->update($validated);

        return back()->with('success', 'Experience updated successfully!');
    }

    public function deleteExperience(Experience $experience)
    {
        $experience->delete();
        return back()->with('success', 'Experience deleted successfully!');
    }

    // ─── Contacts ──────────────────────────────────────────
    public function contacts()
    {
        $contacts = Contact::latest()->paginate(20);
        return view('admin.contacts', compact('contacts'));
    }

    public function markRead(Contact $contact)
    {
        $contact->update(['is_read' => true]);
        return back()->with('success', 'Message marked as read.');
    }

    public function deleteContact(Contact $contact)
    {
        $contact->delete();
        return back()->with('success', 'Message deleted.');
    }
}
