<x-app-layout>
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <div class="flex items-center gap-2 text-sm text-gray-500 mb-4">
            <a href="{{ route('forms.index') }}" class="hover:text-gray-700 transition">Formulir Saya</a>
            <span>/</span>
            <a href="{{ route('responses.index', $form) }}" class="hover:text-gray-700 transition">Tanggapan</a>
            <span>/</span>
            <span class="text-gray-800">Tanggapan #{{ $response->id }}</span>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="h-2" style="background-color: {{ $form->theme_color }}"></div>
            <div class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <h1 class="text-xl font-bold text-gray-800">{{ $form->title }}</h1>
                    <span class="text-sm text-gray-500">{{ $response->submitted_at->format('d M Y, H:i') }}</span>
                </div>

                @if($response->confirmation_code)
                <div class="mb-6 flex items-center gap-2">
                    <span class="text-sm text-gray-500 font-medium">Kode Konfirmasi:</span>
                    <span style="font-family: 'Courier New', monospace; font-size: 14px; font-weight: 700; background: #F0FDF4; color: #16a34a; padding: 4px 12px; border-radius: 8px; border: 1px solid #BBF7D0; letter-spacing: 1px;">{{ $response->confirmation_code }}</span>
                </div>
                @endif

                @if($response->respondent_email)
                <div class="mb-6 text-sm text-gray-600">
                    <strong>Email:</strong> {{ $response->respondent_email }}
                </div>
                @endif

                <div class="space-y-6">
                    @foreach($form->questions as $question)
                    <div class="border-b border-gray-100 pb-4 last:border-0">
                        <p class="text-sm font-medium text-gray-500 mb-1">{{ $question->title }}</p>
                        @php
                            $answer = $response->answers->where('question_id', $question->id)->first();
                        @endphp
                        @if($answer)
                            @if($question->type === 'checkbox')
                                <div class="flex flex-wrap gap-2">
                                    @foreach(json_decode($answer->value, true) ?? [] as $val)
                                        <span class="px-2 py-1 bg-gform-light/30 text-gform text-sm rounded-md">{{ $val }}</span>
                                    @endforeach
                                </div>
                            @elseif($question->type === 'file_upload' && $answer->file_path)
                                <a href="{{ asset('storage/' . $answer->file_path) }}" target="_blank" class="inline-flex items-center gap-1 text-sm text-blue-600 hover:underline">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                                    Lihat File
                                </a>
                            @else
                                <p class="text-sm text-gray-800">{{ $answer->value ?? '-' }}</p>
                            @endif
                        @else
                            <p class="text-sm text-gray-400 italic">Tidak dijawab</p>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="mt-4 flex items-center justify-between">
            <a href="{{ route('responses.index', $form) }}" class="text-sm text-gray-500 hover:text-gray-700 transition">← Semua Tanggapan</a>
        </div>
    </div>
</x-app-layout>
