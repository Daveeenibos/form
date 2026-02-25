<x-app-layout>
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Buat Formulir Baru</h1>

        <form action="{{ route('forms.store') }}" method="POST">
            @csrf
            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                <div class="h-2.5 bg-gform"></div>
                <div class="p-6 space-y-4">
                    <div>
                        <input type="text" name="title" value="{{ old('title', 'Formulir Tanpa Judul') }}"
                               class="w-full text-2xl font-semibold text-gray-800 border-0 border-b-2 border-transparent focus:border-gform focus:ring-0 px-0 py-2 placeholder:text-gray-300 transition"
                               placeholder="Judul formulir">
                        @error('title') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <input type="text" name="description" value="{{ old('description') }}"
                               class="w-full text-sm text-gray-600 border-0 border-b border-transparent focus:border-gray-300 focus:ring-0 px-0 py-2 placeholder:text-gray-400 transition"
                               placeholder="Deskripsi formulir (opsional)">
                    </div>
                    <div>
                        <label class="text-sm text-gray-500 block mb-1">Kategori Layanan</label>
                        <select name="category" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm text-gray-700 focus:ring-gform focus:border-gform">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($categories as $key => $label)
                                <option value="{{ $key }}" {{ old('category') === $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="text-sm text-gray-500 block mb-1">Warna Tema</label>
                        <input type="color" name="theme_color" value="{{ old('theme_color', '#673AB7') }}"
                               class="w-10 h-10 rounded-lg border border-gray-200 cursor-pointer">
                    </div>
                </div>
            </div>

            <div class="mt-6 flex items-center justify-between">
                <a href="{{ route('forms.index') }}" class="text-sm text-gray-500 hover:text-gray-700 transition">← Kembali ke Formulir</a>
                <button type="submit" class="px-6 py-2.5 bg-gform text-white rounded-lg text-sm font-medium hover:bg-gform-dark transition shadow-sm">
                    Buat & Tambah Pertanyaan
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
