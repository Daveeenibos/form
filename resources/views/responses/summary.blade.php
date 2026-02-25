<x-app-layout>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <div>
                <div class="flex items-center gap-2 text-sm text-gray-500 mb-1">
                    <a href="{{ route('forms.index') }}" class="hover:text-gray-700 transition">Formulir Saya</a>
                    <span>/</span>
                    <a href="{{ route('responses.index', $form) }}" class="hover:text-gray-700 transition">Tanggapan</a>
                    <span>/</span>
                    <span class="text-gray-800">Ringkasan</span>
                </div>
                <h1 class="text-2xl font-bold text-gray-800">{{ $form->title }} — Ringkasan</h1>
                <p class="text-sm text-gray-500 mt-1">{{ $totalResponses }} total tanggapan</p>
            </div>
            <a href="{{ route('responses.index', $form) }}" class="px-4 py-2 text-sm text-gray-600 hover:text-gray-800 rounded-lg hover:bg-gray-100 transition">
                ← Kembali ke Tanggapan
            </a>
        </div>

        @if($totalResponses === 0)
            <div class="bg-white rounded-xl border border-gray-200 p-12 text-center">
                <p class="text-gray-500">Belum ada tanggapan</p>
            </div>
        @else
            <div class="space-y-4">
                @foreach($questionSummaries as $qs)
                <div class="bg-white rounded-xl border border-gray-200 p-6">
                    <div class="flex items-center gap-2 mb-1">
                        <span class="text-xs font-medium text-gform bg-gform-light/30 px-2 py-0.5 rounded">
                            {{ \App\Models\Question::TYPES[$qs['question']->type] ?? $qs['question']->type }}
                        </span>
                        <span class="text-xs text-gray-400">{{ $qs['total'] }} jawaban</span>
                    </div>
                    <h3 class="font-semibold text-gray-800 mb-4">{{ $qs['question']->title }}</h3>

                    @if(in_array($qs['question']->type, ['multiple_choice', 'dropdown', 'checkbox']))
                        <!-- Grafik Batang -->
                        <div class="space-y-3">
                            @foreach($qs['data'] as $label => $count)
                            @php $percentage = $qs['total'] > 0 ? round(($count / $qs['total']) * 100) : 0; @endphp
                            <div>
                                <div class="flex items-center justify-between text-sm mb-1">
                                    <span class="text-gray-700">{{ $label }}</span>
                                    <span class="text-gray-500">{{ $count }} ({{ $percentage }}%)</span>
                                </div>
                                <div class="w-full bg-gray-100 rounded-full h-2.5">
                                    <div class="h-2.5 rounded-full transition-all duration-500" style="width: {{ $percentage }}%; background-color: {{ $form->theme_color }}"></div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <!-- Tanggapan Teks -->
                        <div class="max-h-48 overflow-y-auto space-y-2">
                            @foreach($qs['data']->take(10) as $value)
                            <div class="px-3 py-2 bg-gray-50 rounded-lg text-sm text-gray-700">{{ $value }}</div>
                            @endforeach
                            @if($qs['data']->count() > 10)
                            <p class="text-xs text-gray-400 text-center pt-2">dan {{ $qs['data']->count() - 10 }} lainnya...</p>
                            @endif
                        </div>
                    @endif
                </div>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
