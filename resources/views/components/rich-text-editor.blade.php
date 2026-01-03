@props(['name', 'value' => '', 'height' => '300px', 'label' => ''])

<div class="rich-text-editor-container" data-editor-name="{{ $name }}">
    @if($label)
        <label class="block text-sm font-medium text-neutral-700 mb-2">{{ $label }}</label>
    @endif

    <!-- Toolbar -->
    <div class="bg-neutral-50 border border-neutral-300 rounded-t-lg p-2 flex flex-wrap gap-1">
        <!-- Text Formatting -->
        <button type="button" class="editor-btn" data-command="bold" title="Bold (Ctrl+B)">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M6 4h8a4 4 0 014 4 4 4 0 01-4 4H6z M6 12h9a4 4 0 014 4 4 4 0 01-4 4H6z" />
            </svg>
        </button>
        <button type="button" class="editor-btn" data-command="italic" title="Italic (Ctrl+I)">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M10 20l4-16m0 0l4 0m-4 0l-4 0" />
            </svg>
        </button>
        <button type="button" class="editor-btn" data-command="underline" title="Underline (Ctrl+U)">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M7 4v8a5 5 0 0010 0V4M5 20h14" />
            </svg>
        </button>

        <div class="w-px h-6 bg-neutral-300"></div>

        <!-- Alignment -->
        <button type="button" class="editor-btn" data-command="justifyLeft" title="Align Left">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h10M4 18h14" />
            </svg>
        </button>
        <button type="button" class="editor-btn" data-command="justifyCenter" title="Align Center">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M7 12h10M5 18h14" />
            </svg>
        </button>
        <button type="button" class="editor-btn" data-command="justifyRight" title="Align Right">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M10 12h10M6 18h14" />
            </svg>
        </button>

        <div class="w-px h-6 bg-neutral-300"></div>

        <!-- Lists -->
        <button type="button" class="editor-btn" data-command="insertUnorderedList" title="Bullet List">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
        <button type="button" class="editor-btn" data-command="insertOrderedList" title="Numbered List">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
            </svg>
        </button>

        <div class="w-px h-6 bg-neutral-300"></div>

        <!-- Formatting -->
        <select class="editor-select" data-command="formatBlock">
            <option value="p">Paragraph</option>
            <option value="h1">Heading 1</option>
            <option value="h2">Heading 2</option>
            <option value="h3">Heading 3</option>
            <option value="h4">Heading 4</option>
            <option value="h5">Heading 5</option>
            <option value="h6">Heading 6</option>
        </select>

        <div class="w-px h-6 bg-neutral-300"></div>

        <!-- Link -->
        <button type="button" class="editor-btn" data-command="createLink" title="Insert Link">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
            </svg>
        </button>
        <button type="button" class="editor-btn" data-command="unlink" title="Remove Link">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </button>

        <div class="w-px h-6 bg-neutral-300"></div>

        <!-- Undo/Redo -->
        <button type="button" class="editor-btn" data-command="undo" title="Undo">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" />
            </svg>
        </button>
        <button type="button" class="editor-btn" data-command="redo" title="Redo">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 10h-10a8 8 0 00-8 8v2M21 10l-6 6m6-6l-6-6" />
            </svg>
        </button>

        <div class="w-px h-6 bg-neutral-300"></div>

        <!-- View Toggle -->
        <button type="button" class="editor-btn toggle-view" title="Toggle HTML View">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
            </svg>
        </button>
    </div>

    <!-- Editor Area -->
    <div class="editor-content border border-t-0 border-neutral-300 rounded-b-lg bg-white" contenteditable="true"
        style="min-height: {{ $height }}; max-height: 600px; overflow-y: auto; padding: 12px;"
        data-placeholder="Start typing...">
        {!! $value !!}
    </div>

    <!-- HTML Source -->
    <textarea class="editor-source hidden w-full border border-neutral-300 rounded-b-lg p-3 font-mono text-sm"
        style="min-height: {{ $height }}; max-height: 600px;" spellcheck="false"></textarea>

    <!-- Hidden Input for Form Submission -->
    <input type="hidden" name="{{ $name }}" class="editor-input">
</div>

<style>
    .editor-btn {
        @apply p-2 rounded hover:bg-neutral-200 transition-colors text-neutral-700 hover:text-neutral-900;
    }

    .editor-btn:active,
    .editor-btn.active {
        @apply bg-neutral-300;
    }

    .editor-select {
        @apply px-2 py-1 border border-neutral-300 rounded text-sm focus:ring-2 focus:ring-gold-500 focus:border-gold-500;
    }

    .editor-content:empty:before {
        content: attr(data-placeholder);
        @apply text-neutral-400;
    }

    .editor-content:focus {
        @apply outline-none ring-2 ring-gold-500;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const editors = document.querySelectorAll('.rich-text-editor-container');

        editors.forEach(container => {
            const editorContent = container.querySelector('.editor-content');
            const editorSource = container.querySelector('.editor-source');
            const hiddenInput = container.querySelector('.editor-input');
            const toggleViewBtn = container.querySelector('.toggle-view');
            const commandBtns = container.querySelectorAll('.editor-btn[data-command]');
            const formatSelect = container.querySelector('.editor-select[data-command]');

            let isHtmlView = false;

            // Initialize hidden input with existing value
            hiddenInput.value = editorContent.innerHTML;

            // Command buttons
            commandBtns.forEach(btn => {
                btn.addEventListener('click', function (e) {
                    e.preventDefault();
                    const command = this.dataset.command;

                    if (command === 'createLink') {
                        const url = prompt('Enter URL:');
                        if (url) {
                            document.execCommand(command, false, url);
                        }
                    } else {
                        document.execCommand(command, false, null);
                    }
                    editorContent.focus();
                    updateHiddenInput();
                });
            });

            // Format select
            if (formatSelect) {
                formatSelect.addEventListener('change', function () {
                    document.execCommand('formatBlock', false, this.value);
                    editorContent.focus();
                    updateHiddenInput();
                });
            }

            // Toggle view button
            toggleViewBtn.addEventListener('click', function (e) {
                e.preventDefault();
                isHtmlView = !isHtmlView;

                if (isHtmlView) {
                    editorSource.value = editorContent.innerHTML;
                    editorContent.classList.add('hidden');
                    editorSource.classList.remove('hidden');
                    this.classList.add('active');
                } else {
                    editorContent.innerHTML = editorSource.value;
                    editorSource.classList.add('hidden');
                    editorContent.classList.remove('hidden');
                    this.classList.remove('active');
                    updateHiddenInput();
                }
            });

            // Update hidden input on content change
            editorContent.addEventListener('input', updateHiddenInput);
            editorSource.addEventListener('input', function () {
                hiddenInput.value = this.value;
            });

            function updateHiddenInput() {
                hiddenInput.value = editorContent.innerHTML;
            }

            // Update button states based on selection
            editorContent.addEventListener('mouseup', updateButtonStates);
            editorContent.addEventListener('keyup', updateButtonStates);

            function updateButtonStates() {
                commandBtns.forEach(btn => {
                    const command = btn.dataset.command;
                    if (['bold', 'italic', 'underline'].includes(command)) {
                        if (document.queryCommandState(command)) {
                            btn.classList.add('active');
                        } else {
                            btn.classList.remove('active');
                        }
                    }
                });
            }
        });
    });
</script>