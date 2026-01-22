<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Redirect;
use Illuminate\Http\Request;

class RedirectController extends Controller
{
    public function index()
    {
        $redirects = Redirect::latest()->paginate(20);
        return view('admin.redirects.index', compact('redirects'));
    }

    public function create()
    {
        return view('admin.redirects.create');
    }

    public function store(Request $request)
    {
        $fromCol = Redirect::getFromColumn();
        $toCol = Redirect::getToColumn();

        $validated = $request->validate([
            'from_url' => "required|string|unique:redirects,{$fromCol}",
            'to_url' => 'required|string',
            'status_code' => 'required|in:301,302',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        // Map input keys to actual db columns if needed, but mutators handle it if we use model properties
        // However, Redirect::create($validated) uses mass assignment. 
        // We can manually map them to be safe.
        $data = [
            $fromCol => $validated['from_url'],
            $toCol => $validated['to_url'],
            'status_code' => $validated['status_code'],
            'is_active' => $validated['is_active']
        ];

        $redirect = Redirect::create($data);

        // Clear cache just in case (though model events should handle it)
        $redirect->clearCache();

        return redirect()->route('admin.redirects.index')->with('success', 'Redirect created successfully.');
    }

    public function edit(Redirect $redirect)
    {
        return view('admin.redirects.edit', compact('redirect'));
    }

    public function update(Request $request, Redirect $redirect)
    {
        $fromCol = Redirect::getFromColumn();
        $toCol = Redirect::getToColumn();

        $validated = $request->validate([
            'from_url' => "required|string|unique:redirects,{$fromCol}," . $redirect->id,
            'to_url' => 'required|string',
            'status_code' => 'required|in:301,302',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $data = [
            $fromCol => $validated['from_url'],
            $toCol => $validated['to_url'],
            'status_code' => $validated['status_code'],
            'is_active' => $validated['is_active']
        ];

        $redirect->update($data);

        // Clear cache just in case
        $redirect->clearCache();

        return redirect()->route('admin.redirects.index')->with('success', 'Redirect updated successfully.');
    }

    public function destroy(Redirect $redirect)
    {
        $redirect->clearCache();
        $redirect->delete();
        return redirect()->route('admin.redirects.index')->with('success', 'Redirect deleted successfully.');
    }
}
