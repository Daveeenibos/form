<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $form->title }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased min-h-screen py-8" style="background-color: {{ $form->theme_color }}15">
    <div class="max-w-2xl mx-auto px-4">
        <form action="{{ route('form.submit', $form->slug) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <!-- Judul Formulir -->
            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden mb-4">
                <div class="h-2.5" style="background-color: {{ $form->theme_color }}"></div>
                <div class="p-6">
                    <h1 class="text-2xl font-semibold text-gray-800">{{ $form->title }}</h1>
                    @if($form->description)
                        <p class="text-sm text-gray-600 mt-2">{!! nl2br(e($form->description)) !!}</p>
                    @endif
                    <p class="text-xs text-red-500 mt-4">* Wajib diisi</p>
                </div>
            </div>

            @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm mb-4">
                <p class="font-medium">Mohon perbaiki kesalahan berikut:</p>
                <ul class="list-disc ml-5 mt-1">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <!-- Pertanyaan -->
            @foreach($form->questions as $question)
            <div class="bg-white rounded-xl border border-gray-200 p-6 mb-3 {{ $errors->has('answers.'.$question->id) ? 'border-red-300 bg-red-50/30' : '' }}">
                <label class="block text-sm font-medium text-gray-800 mb-3">
                    {{ $question->title }}
                    @if($question->is_required) <span class="text-red-500">*</span> @endif
                </label>
                @if($question->description)
                    <p class="text-xs text-gray-500 mb-3">{{ $question->description }}</p>
                @endif

                @switch($question->type)
                    @case('short_text')
                        <input type="text" name="answers[{{ $question->id }}]" value="{{ old('answers.'.$question->id) }}"
                               class="w-full border-0 border-b border-gray-300 focus:border-gform px-0 py-2 text-sm focus:ring-0 bg-transparent transition"
                               placeholder="Jawaban Anda">
                        @break
                    @case('paragraph')
                        <textarea name="answers[{{ $question->id }}]" rows="3"
                                  class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-gform focus:border-gform transition"
                                  placeholder="Jawaban Anda">{{ old('answers.'.$question->id) }}</textarea>
                        @break
                    @case('multiple_choice')
                        <div class="space-y-2">
                            @foreach($question->options as $option)
                            <label class="flex items-center gap-3 text-sm text-gray-700 py-1 cursor-pointer hover:bg-gray-50 px-2 rounded-lg transition">
                                <input type="radio" name="answers[{{ $question->id }}]" value="{{ $option->value }}"
                                       class="text-gform focus:ring-gform" {{ old('answers.'.$question->id) == $option->value ? 'checked' : '' }}>
                                {{ $option->value }}
                            </label>
                            @endforeach
                        </div>
                        @break
                    @case('checkbox')
                        <div class="space-y-2">
                            @foreach($question->options as $option)
                            <label class="flex items-center gap-3 text-sm text-gray-700 py-1 cursor-pointer hover:bg-gray-50 px-2 rounded-lg transition">
                                <input type="checkbox" name="answers[{{ $question->id }}][]" value="{{ $option->value }}"
                                       class="rounded text-gform focus:ring-gform"
                                       {{ is_array(old('answers.'.$question->id)) && in_array($option->value, old('answers.'.$question->id)) ? 'checked' : '' }}>
                                {{ $option->value }}
                            </label>
                            @endforeach
                        </div>
                        @break
                    @case('dropdown')
                        <select name="answers[{{ $question->id }}]"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-gform focus:border-gform transition">
                            <option value="">Pilih</option>
                            @foreach($question->options as $option)
                            <option value="{{ $option->value }}" {{ old('answers.'.$question->id) == $option->value ? 'selected' : '' }}>
                                {{ $option->value }}
                            </option>
                            @endforeach
                        </select>
                        @break
                    @case('date')
                        <input type="date" name="answers[{{ $question->id }}]" value="{{ old('answers.'.$question->id) }}"
                               class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-gform focus:border-gform transition">
                        @break
                    @case('time')
                        <input type="time" name="answers[{{ $question->id }}]" value="{{ old('answers.'.$question->id) }}"
                               class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-gform focus:border-gform transition">
                        @break
                    @case('file_upload')
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-gform transition cursor-pointer">
                            <input type="file" name="answers[{{ $question->id }}]" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-gform-light/30 file:text-gform hover:file:bg-gform-light/50">
                        </div>
                        @break
                @endswitch

                @error('answers.'.$question->id)
                    <p class="text-xs text-red-500 mt-2">{{ $message }}</p>
                @enderror
            </div>
            @endforeach

            <div class="flex items-center justify-between mb-8">
                <button type="submit" class="px-8 py-2.5 rounded-lg text-sm font-medium text-white shadow-sm hover:shadow-md transition" style="background-color: {{ $form->theme_color }}">
                    Kirim
                </button>
                <button type="reset" class="text-sm text-gray-500 hover:text-gray-700 transition">Hapus formulir</button>
            </div>
        </form>

        <p class="text-center text-xs text-gray-400 mb-8">
            Dibuat dengan <a href="{{ route('home') }}" class="text-gform hover:underline">FormClone</a>
        </p>
    </div>
</body>
</html>
