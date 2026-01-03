@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Media Library</h1>
        <button onclick="document.getElementById('uploadModal').classList.remove('hidden')" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
            <svg class="w-5 h-5 inline mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Upload Media
        </button>
    </div>

    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
        {{ session('error') }}
    </div>
    @endif

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                    <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <div class="ml-5">
                    <p class="text-gray-500 text-sm">Total Files</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $stats['total'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                    <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <div class="ml-5">
                    <p class="text-gray-500 text-sm">Total Size</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ number_format($stats['total_size'] / 1024 / 1024, 2) }} MB</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-purple-500 rounded-md p-3">
                    <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                    </svg>
                </div>
                <div class="ml-5">
                    <p class="text-gray-500 text-sm">Images</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $stats['images'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Media Grid -->
    @if($media->count() > 0)
    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
            @foreach($media as $item)
            <div class="group relative bg-gray-100 rounded-lg overflow-hidden hover:shadow-lg transition-shadow">
                <div class="aspect-square cursor-pointer" onclick="viewImage('{{ $item->url }}', '{{ addslashes($item->original_name) }}')">
                    @if(str_starts_with($item->mime_type, 'image/'))
                        <img src="{{ $item->url }}" alt="{{ $item->original_name }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-gray-200">
                            <svg class="w-12 h-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                        </div>
                    @endif
                </div>
                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 transition-opacity flex items-center justify-center opacity-0 group-hover:opacity-100">
                    <div class="flex space-x-2">
                        <button onclick="viewImage('{{ $item->url }}', '{{ addslashes($item->original_name) }}'); event.stopPropagation();" class="p-2 bg-white rounded-full hover:bg-gray-100" title="View">
                            <svg class="w-5 h-5 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                        <button onclick="copyToClipboard('{{ $item->url }}')" class="p-2 bg-white rounded-full hover:bg-gray-100" title="Copy URL">
                            <svg class="w-5 h-5 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                            </svg>
                        </button>
                        <form action="{{ route('admin.media.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Delete this file?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 bg-red-500 rounded-full hover:bg-red-600" title="Delete">
                                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
                <div class="p-2 bg-white">
                    <p class="text-xs text-gray-600 truncate" title="{{ $item->original_name }}">{{ $item->original_name }}</p>
                    <p class="text-xs text-gray-400">{{ number_format($item->file_size / 1024, 2) }} KB</p>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $media->links() }}
        </div>
    </div>
    @else
    <div class="bg-white shadow-md rounded px-8 py-12 text-center">
        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
        </svg>
        <h3 class="mt-2 text-sm font-medium text-gray-900">No media files</h3>
        <p class="mt-1 text-sm text-gray-500">Get started by uploading a file.</p>
        <div class="mt-6">
            <button onclick="document.getElementById('uploadModal').classList.remove('hidden')" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Upload Media
            </button>
        </div>
    </div>
    @endif
</div>

<!-- Upload Modal -->
<!-- Upload Modal -->
<div id="uploadModal" class="hidden fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <!-- Overlay & Center Container -->
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
        <!-- Backdrop -->
        <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true" onclick="closeUploadModal()"></div>

        <!-- Modal Panel -->
        <div class="relative inline-block w-full max-w-4xl p-6 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-2xl">
            
            <!-- Close Button -->
            <button onclick="closeUploadModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-500">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <div class="sm:flex sm:items-start">
                <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
                    <svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                    </svg>
                </div>
                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                    <h3 class="text-xl leading-6 font-bold text-gray-900" id="modal-title">
                        Upload Media
                    </h3>
                    <p class="mt-1 text-sm text-gray-500">
                        Upload images or documents to your media library.
                    </p>
                    
                    <div class="mt-6">
                        <form id="uploadForm" class="space-y-6">
                            @csrf
                            <div class="border-2 border-dashed border-gray-300 rounded-xl p-10 flex flex-col justify-center items-center group hover:border-blue-500 hover:bg-blue-50 transition-all cursor-pointer" onclick="document.getElementById('fileInput').click()">
                                <div class="p-4 bg-gray-100 rounded-full group-hover:bg-white transition-colors">
                                    <svg class="h-10 w-10 text-gray-400 group-hover:text-blue-500" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </div>
                                <div class="mt-4 text-center">
                                    <p class="text-lg font-medium text-gray-900">Click to select files</p>
                                    <p class="text-sm text-gray-500 mt-1">or drag and drop here</p>
                                    <p class="text-xs text-gray-400 mt-2">PNG, JPG, GIF up to 10MB</p>
                                </div>
                            </div>
                            <input id="fileInput" name="files[]" type="file" class="sr-only" multiple accept="image/*" onchange="handleFileSelect(this)">
                            
                            <!-- File Preview List -->
                            <div id="fileList" class="max-h-60 overflow-y-auto space-y-3"></div>

                            <!-- Progress Bar -->
                            <div id="progressContainer" class="hidden">
                                <div class="flex justify-between mb-1">
                                    <span class="text-sm font-medium text-blue-700">Uploading...</span>
                                    <span class="text-sm font-medium text-blue-700" id="progressText">0%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2.5 overflow-hidden">
                                    <div id="progressBar" class="bg-blue-600 h-2.5 rounded-full transition-all duration-300" style="width: 0%"></div>
                                </div>
                            </div>

                            <!-- Error Message -->
                            <div id="uploadError" class="hidden p-4 text-sm text-red-700 bg-red-100 rounded-lg" role="alert"></div>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="mt-8 bg-gray-50 -mx-6 -mb-6 px-4 py-4 sm:px-6 flex justify-end gap-3 rounded-b-2xl">
                <button type="button" onclick="closeUploadModal()" class="inline-flex justify-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Cancel
                </button>
                <button type="button" onclick="uploadFiles()" id="uploadBtn" class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50 disabled:cursor-not-allowed">
                    Upload Files
                </button>
            </div>
        </div>
    </div>
        </div>
    </div>
</div>

<!-- Image Preview Modal -->
<div id="imageModal" class="hidden fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-black bg-opacity-90" aria-hidden="true" onclick="closeImageModal()"></div>

        <div class="relative inline-block align-middle bg-transparent transform transition-all sm:max-w-6xl w-full">
            <button onclick="closeImageModal()" class="fixed top-5 right-5 z-50 text-white hover:text-gray-300 focus:outline-none bg-black bg-opacity-50 rounded-full p-2 transition-colors">
                <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            
            <div class="flex flex-col items-center">
                <img id="previewImage" src="" alt="Preview" class="max-h-[85vh] w-auto object-contain rounded-lg shadow-2xl">
                <p id="previewCaption" class="mt-4 text-white text-lg font-medium tracking-wide"></p>
            </div>
        </div>
    </div>
</div>

<script>
function copyToClipboard(text) {
    if (navigator.clipboard) {
        navigator.clipboard.writeText(text).then(function() {
            // Optional: Show a toast notification
            const btn = event.currentTarget;
            const originalHtml = btn.innerHTML;
            btn.innerHTML = `<svg class="w-5 h-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>`;
            setTimeout(() => {
                btn.innerHTML = originalHtml;
            }, 2000);
        }, function(err) {
            console.error('Async: Could not copy text: ', err);
        });
    } else {
        // Fallback
        const textArea = document.createElement("textarea");
        textArea.value = text;
        document.body.appendChild(textArea);
        textArea.focus();
        textArea.select();
        try {
            document.execCommand('copy');
            alert('URL copied!');
        } catch (err) {
            console.error('Fallback: Oops, unable to copy', err);
        }
        document.body.removeChild(textArea);
    }
}

function openUploadModal() {
    document.getElementById('uploadModal').classList.remove('hidden');
}

function closeUploadModal() {
    document.getElementById('uploadModal').classList.add('hidden');
    // Reset form
    document.getElementById('uploadForm').reset();
    document.getElementById('fileList').innerHTML = '';
    document.getElementById('progressContainer').classList.add('hidden');
    document.getElementById('uploadError').classList.add('hidden');
    document.getElementById('progressBar').style.width = '0%';
    document.getElementById('progressText').innerText = '0%';
}

// Bind the open button event if necessary, or ensure the button calling this exists
document.querySelectorAll('button').forEach(btn => {
    if(btn.innerText.includes('Upload Media')) {
        btn.onclick = openUploadModal;
    }
});

function handleFileSelect(input) {
    const fileList = document.getElementById('fileList');
    fileList.innerHTML = '';
    
    if (input.files.length > 0) {
        for (let i = 0; i < input.files.length; i++) {
            const file = input.files[i];
            const div = document.createElement('div');
            div.className = 'flex justify-between items-center';
            div.innerHTML = `
                <span class="truncate">${file.name}</span>
                <span class="text-gray-400 text-xs">${(file.size / 1024 / 1024).toFixed(2)} MB</span>
            `;
            fileList.appendChild(div);
        }
    }
}

function uploadFiles() {
    const input = document.getElementById('fileInput');
    if (input.files.length === 0) {
        alert('Please select files first');
        return;
    }

    const formData = new FormData();
    for (let i = 0; i < input.files.length; i++) {
        formData.append('files[]', input.files[i]);
    }
    formData.append('_token', '{{ csrf_token() }}');

    const xhr = new XMLHttpRequest();
    
    // Progress
    xhr.upload.addEventListener('progress', function(e) {
        if (e.lengthComputable) {
            const percentComplete = Math.round((e.loaded / e.total) * 100);
            document.getElementById('progressContainer').classList.remove('hidden');
            document.getElementById('progressBar').style.width = percentComplete + '%';
            document.getElementById('progressText').innerText = percentComplete + '%';
        }
    });

    // Success/Error
    xhr.onload = function() {
        if (xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);
            if (response.success) {
                // Determine redirect URL or reload
                window.location.reload();
            } else {
                showError('Upload failed: ' + (response.message || 'Unknown error'));
            }
        } else {
            showError('Upload failed. Status: ' + xhr.status);
        }
        document.getElementById('uploadBtn').disabled = false;
        document.getElementById('uploadBtn').innerText = 'Upload';
    };

    xhr.onerror = function() {
        showError('Network error occurred');
        document.getElementById('uploadBtn').disabled = false;
        document.getElementById('uploadBtn').innerText = 'Upload';
    };

    // UI Updates before send
    document.getElementById('uploadError').classList.add('hidden');
    document.getElementById('uploadBtn').disabled = true;
    document.getElementById('uploadBtn').innerText = 'Uploading...';
    
    // Send
    xhr.open('POST', '{{ route('admin.media.store') }}', true);
    // Add header to tell controller we want JSON if not automatically handled by wantsJson() checks which look for Accept header usually
    xhr.setRequestHeader('Accept', 'application/json');
    xhr.send(formData);
}

function showError(msg) {
    const el = document.getElementById('uploadError');
    el.innerText = msg;
    el.classList.remove('hidden');
}

// Image Preview Functions
function viewImage(url, name) {
    // Only open for images
    if (!url.match(/\.(jpeg|jpg|gif|png|webp|svg)$/i)) {
        return;
    }
    
    const modal = document.getElementById('imageModal');
    const img = document.getElementById('previewImage');
    const caption = document.getElementById('previewCaption');
    
    img.src = url;
    caption.innerText = name || '';
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden'; // Prevent scrolling
}

function closeImageModal() {
    const modal = document.getElementById('imageModal');
    modal.classList.add('hidden');
    document.getElementById('previewImage').src = '';
    document.body.style.overflow = ''; // Restore scrolling
}

// Close on escape key
document.addEventListener('keydown', function(event) {
    if (event.key === "Escape") {
        closeImageModal();
        closeUploadModal();
    }
});
</script>
@endsection
