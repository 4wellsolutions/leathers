<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    public function index(Request $request)
    {
        $query = Media::with('uploader');

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('file_name', 'like', "%{$search}%")
                  ->orWhere('alt_text', 'like', "%{$search}%");
            });
        }

        // File type filter
        if ($request->filled('type')) {
            $query->where('file_type', $request->type);
        }

        // Stats
        $stats = [
            'total' => Media::count(),
            'images' => Media::where('file_type', 'image')->count(),
            'videos' => Media::where('file_type', 'video')->count(),
            'documents' => Media::where('file_type', 'document')->count(),
            'total_size' => Media::sum('file_size'),
        ];

        $media = $query->latest()->paginate(24)->withQueryString();

        if ($request->wantsJson()) {
            return response()->json($media);
        }

        return view('admin.media.index', compact('media', 'stats'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'files.*' => 'required|file|max:10240', // 10MB max
        ]);

        $uploadedFiles = [];

        foreach ($request->file('files') as $file) {
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('media', $fileName, 'public');
            
            // Determine file type
            $mimeType = $file->getMimeType();
            $fileType = 'document';
            
            if (str_starts_with($mimeType, 'image/')) {
                $fileType = 'image';
            } elseif (str_starts_with($mimeType, 'video/')) {
                $fileType = 'video';
            }

            // Get image dimensions if it's an image
            $width = null;
            $height = null;
            
            if ($fileType === 'image') {
                try {
                    list($width, $height) = getimagesize($file->getRealPath());
                } catch (\Exception $e) {
                    // Ignore errors
                }
            }

            $media = Media::create([
                'file_name' => $fileName,
                'file_path' => $filePath,
                'file_type' => $fileType,
                'mime_type' => $mimeType,
                'file_size' => $file->getSize(),
                'width' => $width,
                'height' => $height,
                'uploaded_by' => auth()->id(),
            ]);

            $uploadedFiles[] = $media;
        }

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'files' => $uploadedFiles
            ]);
        }

        return redirect()->route('admin.media.index')->with('success', count($uploadedFiles) . ' file(s) uploaded successfully');
    }

    public function update(Request $request, Media $medium)
    {
        $validated = $request->validate([
            'alt_text' => 'nullable|string|max:255',
            'caption' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        $medium->update($validated);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'media' => $medium
            ]);
        }

        return redirect()->route('admin.media.index')->with('success', 'Media updated successfully');
    }

    public function destroy(Media $medium)
    {
        // Delete file from storage
        if (Storage::disk('public')->exists($medium->file_path)) {
            Storage::disk('public')->delete($medium->file_path);
        }

        $medium->delete();

        return redirect()->route('admin.media.index')->with('success', 'Media deleted successfully');
    }
}
