<x-app-layout>
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8" x-data="formBuilder()" x-init="init()">
        <!-- Header Formulir -->
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-4">
                <a href="{{ route('forms.index') }}" class="p-2 text-gray-400 hover:text-gray-600 rounded-lg hover:bg-gray-100 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </a>
                <h1 class="text-lg font-semibold text-gray-800">Edit Formulir</h1>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('forms.preview', $form) }}" class="px-3 py-2 text-sm text-gray-600 hover:text-gray-800 rounded-lg hover:bg-gray-100 transition" title="Pratinjau">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                </a>
                <a href="{{ route('responses.index', $form) }}" class="px-3 py-2 text-sm text-gray-600 hover:text-gray-800 rounded-lg hover:bg-gray-100 transition">
                    Tanggapan
                </a>
                <button @click="copyLink()" class="px-3 py-2 text-sm text-gray-600 hover:text-gray-800 rounded-lg hover:bg-gray-100 transition flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                    Bagikan
                </button>
            </div>
        </div>

        <!-- Kartu Judul Formulir -->
        <form action="{{ route('forms.update', $form) }}" method="POST" class="mb-4">
            @csrf @method('PUT')
            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                <div class="h-2.5" style="background-color: {{ $form->theme_color }}"></div>
                <div class="p-6 space-y-3">
                    <input type="text" name="title" value="{{ $form->title }}"
                           class="w-full text-2xl font-semibold text-gray-800 border-0 border-b-2 border-transparent focus:border-gform focus:ring-0 px-0 py-2 transition"
                           placeholder="Judul formulir">
                    <input type="text" name="description" value="{{ $form->description }}"
                           class="w-full text-sm text-gray-600 border-0 border-b border-transparent focus:border-gray-300 focus:ring-0 px-0 py-1 transition"
                           placeholder="Deskripsi formulir (opsional)">
                    <div class="flex items-center gap-4 pt-2">
                        <div class="flex items-center gap-2">
                            <label class="text-xs text-gray-500">Tema</label>
                            <input type="color" name="theme_color" value="{{ $form->theme_color }}" class="w-8 h-8 rounded border border-gray-200 cursor-pointer">
                        </div>
                        <button type="submit" class="px-4 py-1.5 bg-gform text-white rounded-md text-xs font-medium hover:bg-gform-dark transition">Simpan Pengaturan</button>
                    </div>
                </div>
            </div>
        </form>

        <!-- Daftar Pertanyaan -->
        <div id="questions-container" class="space-y-3">
            @foreach($form->questions as $question)
            <div class="question-card bg-white rounded-xl border border-gray-200 p-5 hover:shadow-md transition group" data-question-id="{{ $question->id }}">
                <div class="flex items-start justify-between gap-4">
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="text-xs font-medium text-gform bg-gform-light/30 px-2 py-0.5 rounded">{{ \App\Models\Question::TYPES[$question->type] ?? $question->type }}</span>
                            @if($question->is_required) <span class="text-red-500 text-xs">*Wajib</span> @endif
                        </div>
                        <p class="font-medium text-gray-800">{{ $question->title }}</p>
                        @if($question->description)
                            <p class="text-xs text-gray-500 mt-1">{{ $question->description }}</p>
                        @endif
                        @if($question->hasOptions())
                            <div class="mt-2 space-y-1">
                                @foreach($question->options as $option)
                                    <div class="flex items-center gap-2 text-sm text-gray-600">
                                        @if($question->type === 'checkbox')
                                            <div class="w-3.5 h-3.5 border-2 border-gray-300 rounded-sm"></div>
                                        @elseif($question->type === 'multiple_choice')
                                            <div class="w-3.5 h-3.5 border-2 border-gray-300 rounded-full"></div>
                                        @else
                                            <span class="text-gray-400">•</span>
                                        @endif
                                        {{ $option->value }}
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                    <div class="flex items-center gap-1 opacity-0 group-hover:opacity-100 transition">
                        <button @click="editQuestion({{ $question->id }})" class="p-1.5 text-gray-400 hover:text-gform rounded-lg hover:bg-gray-100 transition" title="Edit">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </button>
                        <button @click="deleteQuestion({{ $question->id }})" class="p-1.5 text-gray-400 hover:text-red-500 rounded-lg hover:bg-gray-100 transition" title="Hapus">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Tombol Tambah Pertanyaan -->
        <div class="mt-4 mb-8">
            <button @click="showAddModal = true" class="w-full py-4 border-2 border-dashed border-gray-300 rounded-xl text-gray-400 hover:text-gform hover:border-gform transition flex items-center justify-center gap-2 text-sm font-medium">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Pertanyaan
            </button>
        </div>

        <!-- Modal Tambah/Edit Pertanyaan -->
        <div x-show="showAddModal || showEditModal" x-transition class="fixed inset-0 z-50 flex items-center justify-center bg-black/50" @click.self="closeModals()">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg mx-4 max-h-[90vh] overflow-y-auto" @click.stop>
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4" x-text="showEditModal ? 'Edit Pertanyaan' : 'Tambah Pertanyaan'"></h3>

                    <div class="space-y-4">
                        <!-- Tipe Pertanyaan -->
                        <div>
                            <label class="text-sm font-medium text-gray-700 block mb-1">Tipe Pertanyaan</label>
                            <select x-model="questionForm.type" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-gform focus:border-gform">
                                <option value="short_text">Jawaban Singkat</option>
                                <option value="paragraph">Paragraf</option>
                                <option value="multiple_choice">Pilihan Ganda</option>
                                <option value="checkbox">Kotak Centang</option>
                                <option value="dropdown">Dropdown</option>
                                <option value="date">Tanggal</option>
                                <option value="time">Waktu</option>
                                <option value="file_upload">Unggah File</option>
                            </select>
                        </div>

                        <!-- Judul Pertanyaan -->
                        <div>
                            <label class="text-sm font-medium text-gray-700 block mb-1">Pertanyaan</label>
                            <input type="text" x-model="questionForm.title" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-gform focus:border-gform" placeholder="Masukkan pertanyaan Anda">
                        </div>

                        <!-- Deskripsi -->
                        <div>
                            <label class="text-sm font-medium text-gray-700 block mb-1">Deskripsi (opsional)</label>
                            <input type="text" x-model="questionForm.description" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-gform focus:border-gform" placeholder="Teks bantuan untuk responden">
                        </div>

                        <!-- Opsi (untuk tipe pilihan) -->
                        <div x-show="['multiple_choice','checkbox','dropdown'].includes(questionForm.type)">
                            <label class="text-sm font-medium text-gray-700 block mb-2">Pilihan</label>
                            <template x-for="(opt, index) in questionForm.options" :key="index">
                                <div class="flex items-center gap-2 mb-2">
                                    <input type="text" x-model="questionForm.options[index]" class="flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-gform focus:border-gform" :placeholder="'Pilihan ' + (index + 1)">
                                    <button @click="questionForm.options.splice(index, 1)" class="p-1.5 text-gray-400 hover:text-red-500 transition" x-show="questionForm.options.length > 1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                    </button>
                                </div>
                            </template>
                            <button @click="questionForm.options.push('')" class="text-sm text-gform hover:text-gform-dark font-medium mt-1">+ Tambah Pilihan</button>
                        </div>

                        <!-- Wajib Diisi -->
                        <div class="flex items-center gap-2">
                            <input type="checkbox" x-model="questionForm.is_required" id="is_required" class="rounded border-gray-300 text-gform focus:ring-gform">
                            <label for="is_required" class="text-sm text-gray-700">Wajib diisi</label>
                        </div>
                    </div>

                    <div class="mt-6 flex items-center justify-end gap-3">
                        <button @click="closeModals()" class="px-4 py-2 text-sm text-gray-600 hover:text-gray-800 transition">Batal</button>
                        <button @click="saveQuestion()" class="px-5 py-2 bg-gform text-white rounded-lg text-sm font-medium hover:bg-gform-dark transition">
                            <span x-text="showEditModal ? 'Perbarui' : 'Tambah Pertanyaan'"></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Toast Salin Link -->
        <div x-show="showToast" x-transition class="fixed bottom-6 left-1/2 -translate-x-1/2 bg-gray-800 text-white px-4 py-2 rounded-lg text-sm shadow-lg z-50">
            Link berhasil disalin!
        </div>
    </div>

    @push('scripts')
    <script>
        const FORM_ID = {{ $form->id }};
        const CSRF_TOKEN = '{{ csrf_token() }}';
        const FORM_PUBLIC_URL = '{{ $form->public_url }}';
        @php
            $questionsData = $form->questions->mapWithKeys(function($q) {
                return [$q->id => [
                    'type' => $q->type,
                    'title' => $q->title,
                    'description' => $q->description,
                    'is_required' => $q->is_required,
                    'options' => $q->options->map(fn($o) => $o->value)->toArray(),
                ]];
            });
        @endphp
        const QUESTIONS_DATA = {!! json_encode($questionsData) !!};

        function formBuilder() {
            return {
                showAddModal: false,
                showEditModal: false,
                showToast: false,
                editingQuestionId: null,
                questionForm: {
                    type: 'short_text',
                    title: '',
                    description: '',
                    is_required: false,
                    options: ['']
                },

                init() {},

                resetForm() {
                    this.questionForm = {
                        type: 'short_text',
                        title: '',
                        description: '',
                        is_required: false,
                        options: ['']
                    };
                },

                closeModals() {
                    this.showAddModal = false;
                    this.showEditModal = false;
                    this.resetForm();
                },

                copyLink() {
                    navigator.clipboard.writeText(FORM_PUBLIC_URL);
                    this.showToast = true;
                    setTimeout(() => this.showToast = false, 2000);
                },

                editQuestion(questionId) {
                    try {
                        const data = QUESTIONS_DATA[questionId];
                        if (!data) {
                            alert('Data pertanyaan tidak ditemukan');
                            return;
                        }

                        this.editingQuestionId = questionId;
                        this.questionForm = {
                            type: data.type,
                            title: data.title || '',
                            description: data.description || '',
                            is_required: data.is_required,
                            options: data.options && data.options.length ? [...data.options] : ['']
                        };
                        this.showEditModal = true;
                    } catch (err) {
                        alert('Error: ' + err.message);
                    }
                },

                deleteQuestion(questionId) {
                    if (!confirm('Hapus pertanyaan ini?')) return;

                    fetch(`/forms/${FORM_ID}/questions/${questionId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': CSRF_TOKEN,
                            'Accept': 'application/json'
                        }
                    }).then(res => {
                        if (res.ok) location.reload();
                    });
                },

                async saveQuestion() {
                    const url = this.showEditModal
                        ? `/forms/${FORM_ID}/questions/${this.editingQuestionId}`
                        : `/forms/${FORM_ID}/questions`;

                    const method = this.showEditModal ? 'PUT' : 'POST';

                    const body = {
                        type: this.questionForm.type,
                        title: this.questionForm.title || 'Pertanyaan Tanpa Judul',
                        description: this.questionForm.description || null,
                        is_required: this.questionForm.is_required,
                        options: ['multiple_choice','checkbox','dropdown'].includes(this.questionForm.type)
                            ? this.questionForm.options.filter(o => o.trim() !== '')
                            : []
                    };

                    try {
                        const res = await fetch(url, {
                            method: method,
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': CSRF_TOKEN,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify(body)
                        });

                        if (res.ok) {
                            this.closeModals();
                            location.reload();
                        } else {
                            const data = await res.json();
                            alert(data.message || 'Gagal menyimpan pertanyaan');
                        }
                    } catch (err) {
                        alert('Gagal menyimpan pertanyaan');
                    }
                }
            };
        }
    </script>
    @endpush
</x-app-layout>
