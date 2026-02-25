<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $form->title }} - Pratinjau</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gform-light/20 min-h-screen py-8">
    <div class="max-w-2xl mx-auto px-4">
        <!-- Banner Pratinjau -->
        <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 px-4 py-3 rounded-lg text-sm mb-4 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                Ini adalah pratinjau. Pengiriman tidak akan disimpan.
            </div>
            <a href="{{ route('forms.edit', $form) }}" class="text-sm font-medium text-yellow-800 hover:underline">← Kembali ke Editor</a>
        </div>

        <!-- Judul Formulir -->
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden mb-4">
            <div class="h-2.5" style="background-color: {{ $form->theme_color }}"></div>
            <div class="p-6">
                <h1 class="text-2xl font-semibold text-gray-800">{{ $form->title }}</h1>
                @if($form->description)
                    <p class="text-sm text-gray-600 mt-2">{{ $form->description }}</p>
                @endif
            </div>
        </div>

        <!-- Pertanyaan -->
        @foreach($form->questions as $question)
        <div class="bg-white rounded-xl border border-gray-200 p-6 mb-3">
            <label class="block text-sm font-medium text-gray-800 mb-3">
                {{ $question->title }}
                @if($question->is_required) <span class="text-red-500">*</span> @endif
            </label>
            @if($question->description)
                <p class="text-xs text-gray-500 mb-3">{{ $question->description }}</p>
            @endif

            @switch($question->type)
                @case('short_text')
                    <input type="text" disabled class="w-full border-0 border-b border-gray-300 px-0 py-2 text-sm focus:ring-0 bg-transparent" placeholder="Teks jawaban singkat">
                    @break
                @case('paragraph')
                    <textarea disabled rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm bg-transparent" placeholder="Teks jawaban panjang"></textarea>
                    @break
                @case('multiple_choice')
                    <div class="space-y-2">
                        @foreach($question->options as $option)
                        <label class="flex items-center gap-3 text-sm text-gray-700">
                            <input type="radio" disabled class="text-gform focus:ring-gform"> {{ $option->value }}
                        </label>
                        @endforeach
                    </div>
                    @break
                @case('checkbox')
                    <div class="space-y-2">
                        @foreach($question->options as $option)
                        <label class="flex items-center gap-3 text-sm text-gray-700">
                            <input type="checkbox" disabled class="rounded text-gform focus:ring-gform"> {{ $option->value }}
                        </label>
                        @endforeach
                    </div>
                    @break
                @case('dropdown')
                    <select disabled class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                        <option value="">Pilih</option>
                        @foreach($question->options as $option)
                        <option>{{ $option->value }}</option>
                        @endforeach
                    </select>
                    @break
                @case('date')
                    <input type="date" disabled class="border border-gray-300 rounded-lg px-3 py-2 text-sm">
                    @break
                @case('time')
                    <input type="time" disabled class="border border-gray-300 rounded-lg px-3 py-2 text-sm">
                    @break
                @case('file_upload')
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center text-sm text-gray-400">
                        <svg class="w-8 h-8 mx-auto mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                        Unggah file
                    </div>
                    @break
            @endswitch
        </div>
        @endforeach

        <div class="flex justify-end mb-8">
            <button disabled class="px-6 py-2.5 rounded-lg text-sm font-medium text-white opacity-50" style="background-color: {{ $form->theme_color }}">Kirim</button>
        </div>
    </div>
</body>
</html>
