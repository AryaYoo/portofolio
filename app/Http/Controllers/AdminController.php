<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Project;
use App\Models\ProjectSection;
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
            'social_links' => 'nullable|array',
        ]);

        $profile = Profile::first();

        if ($request->hasFile('photo')) {
            $request->validate(['photo' => 'image|mimes:jpg,jpeg,png,webp|max:2048']);
            if ($profile->photo) {
                Storage::disk('public')->delete($profile->photo);
            }
            $validated['photo'] = $request->file('photo')->store('profile', 'public');
        }

        if ($request->hasFile('favicon')) {
            $request->validate(['favicon' => 'image|mimes:ico,png,svg,jpg,jpeg,webp|max:1024']);
            if ($profile->favicon) {
                Storage::disk('public')->delete($profile->favicon);
            }
            $validated['favicon'] = $request->file('favicon')->store('profile', 'public');
        }

        for ($i = 1; $i <= 4; $i++) {
            $fieldName = "wallpaper_$i";
            if ($request->hasFile($fieldName)) {
                $request->validate([$fieldName => 'image|mimes:jpg,jpeg,png,webp|max:5120']);
                if ($profile->$fieldName) {
                    Storage::disk('public')->delete($profile->$fieldName);
                }
                $validated[$fieldName] = $request->file($fieldName)->store('profile', 'public');
            }
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

    // ─── Project Sections (Modular Page) ──────────────────────
    public function sections(Project $project)
    {
        $project->load('sections');
        return view('admin.projects.sections', compact('project'));
    }

    public function storeSection(Request $request, Project $project)
    {
        $validated = $request->validate([
            'type' => 'required|in:hero,model1,model2,model3,demo',
            'title' => 'nullable|string|max:255',
            'content' => 'nullable|string',
            'image' => 'nullable|image|max:5120',
            'sort_order' => 'nullable|integer',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('project_sections', 'public');
        }

        $project->sections()->create($validated);

        return back()->with('success', 'Section added successfully!');
    }

    public function editSection(ProjectSection $section)
    {
        return view('admin.projects.section_edit', compact('section'));
    }

    public function updateSection(Request $request, ProjectSection $section)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'content' => 'nullable|string',
            'image' => 'nullable|image|max:5120',
            'sort_order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            if ($section->image) {
                Storage::disk('public')->delete($section->image);
            }
            $validated['image'] = $request->file('image')->store('project_sections', 'public');
        }

        $section->update($validated);

        return back()->with('success', 'Section updated successfully!');
    }

    public function deleteSection(ProjectSection $section)
    {
        if ($section->image) {
            Storage::disk('public')->delete($section->image);
        }
        $section->delete();
        return back()->with('success', 'Section deleted successfully!');
    }

    private function validateProject(Request $request): array
    {
        return $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'theme_color' => 'nullable|string|max:20',
            'description' => 'nullable|string',
            'screenshot' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
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
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'category' => 'nullable|string|max:100',
            'description' => 'nullable|string|max:1000',
            'tags' => 'nullable|string|max:500',
            'level' => 'nullable|integer|min:0|max:100',
            'sort_order' => 'nullable|integer',
        ]);

        // Convert comma-separated tags to array
        if (!empty($validated['tags'])) {
            $validated['tags'] = array_map('trim', explode(',', $validated['tags']));
        }

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('skills', 'public');
        }

        Skill::create($validated);

        return back()->with('success', 'Certification added successfully!');
    }

    public function updateSkill(Request $request, Skill $skill)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'icon' => 'nullable|string|max:50',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'category' => 'nullable|string|max:100',
            'description' => 'nullable|string|max:1000',
            'tags' => 'nullable|string|max:500',
            'level' => 'nullable|integer|min:0|max:100',
            'sort_order' => 'nullable|integer',
        ]);

        if (!empty($validated['tags'])) {
            $validated['tags'] = array_map('trim', explode(',', $validated['tags']));
        }

        if ($request->hasFile('image')) {
            if ($skill->image) {
                Storage::disk('public')->delete($skill->image);
            }
            $validated['image'] = $request->file('image')->store('skills', 'public');
        }

        $skill->update($validated);

        return back()->with('success', 'Certification updated successfully!');
    }

    public function deleteSkill(Skill $skill)
    {
        if ($skill->image) {
            Storage::disk('public')->delete($skill->image);
        }
        $skill->delete();
        return back()->with('success', 'Certification deleted successfully!');
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
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'location' => 'nullable|string|max:255',
            'period' => 'required|string|max:100',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer',
        ]);

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('experience', 'public');
        }

        Experience::create($validated);

        return back()->with('success', 'Experience added successfully!');
    }

    public function updateExperience(Request $request, Experience $experience)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'location' => 'nullable|string|max:255',
            'period' => 'required|string|max:100',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer',
        ]);

        if ($request->hasFile('logo')) {
            if ($experience->logo) {
                Storage::disk('public')->delete($experience->logo);
            }
            $validated['logo'] = $request->file('logo')->store('experience', 'public');
        }

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
