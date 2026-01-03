<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmailTemplate;
use Illuminate\Http\Request;

class EmailTemplateController extends Controller
{
    public function index(Request $request)
    {
        $query = EmailTemplate::query();

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        // Stats
        $stats = [
            'total' => EmailTemplate::count(),
            'active' => EmailTemplate::where('is_active', true)->count(),
            'inactive' => EmailTemplate::where('is_active', false)->count(),
        ];

        $templates = $query->latest()->paginate(15)->withQueryString();
        
        return view('admin.email-templates.index', compact('templates', 'stats'));
    }

    public function create()
    {
        return view('admin.email-templates.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:email_templates',
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
            'variables' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        EmailTemplate::create($validated);

        return redirect()->route('admin.email-templates.index')->with('success', 'Email template created successfully');
    }

    public function edit(EmailTemplate $emailTemplate)
    {
        return view('admin.email-templates.edit', compact('emailTemplate'));
    }

    public function update(Request $request, EmailTemplate $emailTemplate)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:email_templates,name,' . $emailTemplate->id,
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
            'variables' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $emailTemplate->update($validated);

        return redirect()->route('admin.email-templates.index')->with('success', 'Email template updated successfully');
    }

    public function destroy(EmailTemplate $emailTemplate)
    {
        $emailTemplate->delete();

        return redirect()->route('admin.email-templates.index')->with('success', 'Email template deleted successfully');
    }
}
