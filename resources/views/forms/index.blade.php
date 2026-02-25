<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Formulir Saya</h1>
            <a href="{{ route('forms.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-gform text-white rounded-lg text-sm font-medium hover:bg-gform-dark transition shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Formulir Baru
            </a>
        </div>

        @if($forms->isEmpty())
            <div class="bg-white rounded-xl border border-gray-200 p-16 text-center">
                <svg class="w-20 h-20 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                <h3 class="text-lg font-medium text-gray-500 mb-2">Belum ada formulir</h3>
                <p class="text-gray-400 mb-6">Mulai dengan membuat formulir pertama Anda</p>
                <a href="{{ route('forms.create') }}" class="px-5 py-2.5 bg-gform text-white rounded-lg text-sm font-medium hover:bg-gform-dark transition">Buat Formulir</a>
            </div>
        @else
            <div class="bg-white rounded-xl border border-gray-200 overflow-visible">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Formulir</th>
                            <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Tanggapan</th>
                            <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Status</th>
                            <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Dibuat</th>
                            <th class="text-right px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($forms as $form)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-1 h-8 rounded-full" style="background-color: {{ $form->theme_color }}"></div>
                                    <div>
                                        <a href="{{ route('forms.edit', $form) }}" class="font-medium text-gray-800 hover:text-gform transition">{{ $form->title }}</a>
                                        <div class="flex items-center gap-2 mt-0.5">
                                            <p class="text-xs text-gray-400">{{ $form->questions_count }} pertanyaan</p>
                                            @if($form->category)
                                                <span class="text-xs bg-gform-light/30 text-gform px-1.5 py-0.5 rounded">{{ \App\Models\Form::CATEGORIES[$form->category] ?? $form->category }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ route('responses.index', $form) }}" class="text-sm text-gform hover:underline">{{ $form->responses_count }} tanggapan</a>
                            </td>
                            <td class="px-6 py-4">
                                <form action="{{ route('forms.toggle', $form) }}" method="POST" class="inline">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="px-2.5 py-1 text-xs font-medium rounded-full transition {{ $form->is_active ? 'bg-green-100 text-green-700 hover:bg-green-200' : 'bg-gray-100 text-gray-500 hover:bg-gray-200' }}">
                                        {{ $form->is_active ? 'Aktif' : 'Nonaktif' }}
                                    </button>
                                </form>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $form->created_at->format('d M Y') }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end gap-1" x-data="{ open: false }">
                                    <a href="{{ route('forms.edit', $form) }}" class="p-2 text-gray-400 hover:text-gform rounded-lg hover:bg-gray-100 transition" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>
                                    <button @click="navigator.clipboard.writeText('{{ $form->public_url }}')" class="p-2 text-gray-400 hover:text-blue-600 rounded-lg hover:bg-gray-100 transition" title="Salin Link">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                                    </button>
                                    <div class="relative">
                                        <button @click="open = !open" class="p-2 text-gray-400 hover:text-gray-600 rounded-lg hover:bg-gray-100 transition">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"/></svg>
                                        </button>
                                        <div x-show="open" @click.outside="open = false" x-transition class="absolute right-0 mt-1 w-44 bg-white rounded-lg shadow-lg border border-gray-200 py-1 z-50">
                                            <a href="{{ route('forms.preview', $form) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Pratinjau</a>
                                            <a href="{{ route('responses.index', $form) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Lihat Tanggapan</a>
                                            <form action="{{ route('forms.duplicate', $form) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Duplikat</button>
                                            </form>
                                            <hr class="my-1">
                                            <form action="{{ route('forms.destroy', $form) }}" method="POST" onsubmit="return confirm('Hapus formulir ini?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">Hapus</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</x-app-layout>
