<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Statistik -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
            <div class="bg-white rounded-xl border border-gray-200 p-6 hover:shadow-md transition">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-gform-light/40 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-gform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Total Formulir</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['total_forms'] }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl border border-gray-200 p-6 hover:shadow-md transition">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Formulir Aktif</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['active_forms'] }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl border border-gray-200 p-6 hover:shadow-md transition">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Total Tanggapan</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['total_responses'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Formulir Terbaru -->
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-semibold text-gray-800">Formulir Terbaru</h2>
            <a href="{{ route('forms.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-gform text-white rounded-lg text-sm font-medium hover:bg-gform-dark transition shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Formulir Baru
            </a>
        </div>

        @if($forms->isEmpty())
            <div class="bg-white rounded-xl border border-gray-200 p-12 text-center">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                <h3 class="text-lg font-medium text-gray-500 mb-2">Belum ada formulir</h3>
                <p class="text-gray-400 mb-6">Buat formulir pertama Anda untuk memulai</p>
                <a href="{{ route('forms.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gform text-white rounded-lg text-sm font-medium hover:bg-gform-dark transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Buat Formulir
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($forms->take(6) as $form)
                <a href="{{ route('forms.edit', $form) }}" class="bg-white rounded-xl border border-gray-200 overflow-hidden hover:shadow-lg transition group">
                    <div class="h-2" style="background-color: {{ $form->theme_color }}"></div>
                    <div class="p-5">
                        <div class="flex items-start justify-between">
                            <div class="flex-1 min-w-0">
                                <h3 class="font-semibold text-gray-800 truncate group-hover:text-gform transition">{{ $form->title }}</h3>
                                <p class="text-sm text-gray-500 mt-1">{{ $form->created_at->diffForHumans() }}</p>
                            </div>
                            <span class="ml-2 px-2 py-0.5 text-xs font-medium rounded-full {{ $form->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                                {{ $form->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </div>
                        <div class="mt-4 flex items-center gap-4 text-xs text-gray-400">
                            <span>{{ $form->responses_count }} tanggapan</span>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
            @if($forms->count() > 6)
            <div class="mt-4 text-center">
                <a href="{{ route('forms.index') }}" class="text-gform hover:text-gform-dark text-sm font-medium">Lihat semua formulir →</a>
            </div>
            @endif
        @endif
    </div>
</x-app-layout>
