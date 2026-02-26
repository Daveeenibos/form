<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <div>
                <div class="flex items-center gap-2 text-sm text-gray-500 mb-1">
                    <a href="{{ route('forms.index') }}" class="hover:text-gray-700 transition">Formulir Saya</a>
                    <span>/</span>
                    <a href="{{ route('forms.edit', $form) }}" class="hover:text-gray-700 transition">{{ $form->title }}</a>
                    <span>/</span>
                    <span class="text-gray-800">Tanggapan</span>
                </div>
                <h1 class="text-2xl font-bold text-gray-800">{{ $responses->total() }} Tanggapan</h1>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('responses.summary', $form) }}" class="px-4 py-2 text-sm text-gray-600 hover:text-gray-800 rounded-lg hover:bg-gray-100 transition flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    Ringkasan
                </a>
                <a href="{{ route('responses.export', $form) }}" class="px-4 py-2 bg-gform text-white text-sm font-medium rounded-lg hover:bg-gform-dark transition flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Ekspor CSV
                </a>
            </div>
        </div>

        @if($responses->isEmpty())
            <div class="bg-white rounded-xl border border-gray-200 p-12 text-center">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                <h3 class="text-lg font-medium text-gray-500 mb-2">Belum ada tanggapan</h3>
                <p class="text-gray-400 mb-4">Bagikan link formulir Anda untuk mulai mengumpulkan tanggapan</p>
                <button onclick="navigator.clipboard.writeText('{{ $form->public_url }}')" class="px-4 py-2 bg-gform text-white rounded-lg text-sm font-medium hover:bg-gform-dark transition">
                    Salin Link Formulir
                </button>
            </div>
        @else
            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">#</th>
                                <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Kode Konfirmasi</th>
                                <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Dikirim</th>
                                <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Email</th>
                                @foreach($form->questions->take(3) as $q)
                                <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase max-w-[150px] truncate">{{ $q->title }}</th>
                                @endforeach
                                <th class="text-right px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($responses as $index => $response)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-4 py-3 text-sm text-gray-500">{{ $responses->firstItem() + $index }}</td>
                                <td class="px-4 py-3">
                                    <span style="font-family: 'Courier New', monospace; font-size: 12px; font-weight: 600; background: #F0FDF4; color: #16a34a; padding: 3px 8px; border-radius: 6px; border: 1px solid #BBF7D0;">{{ $response->confirmation_code ?? '-' }}</span>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-600">{{ $response->submitted_at->format('d M, H:i') }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600">{{ $response->respondent_email ?? '-' }}</td>
                                @foreach($form->questions->take(3) as $q)
                                <td class="px-4 py-3 text-sm text-gray-600 max-w-[150px] truncate">
                                    @php
                                        $answer = $response->answers->where('question_id', $q->id)->first();
                                    @endphp
                                    @if($answer)
                                        @if($q->type === 'checkbox')
                                            {{ implode(', ', json_decode($answer->value, true) ?? []) }}
                                        @elseif($q->type === 'file_upload')
                                            📎 File
                                        @else
                                            {{ Str::limit($answer->value, 40) }}
                                        @endif
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                @endforeach
                                <td class="px-4 py-3 text-right">
                                    <a href="{{ route('responses.show', [$form, $response]) }}" class="text-sm text-gform hover:text-gform-dark font-medium">Lihat →</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-4">
                {{ $responses->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
