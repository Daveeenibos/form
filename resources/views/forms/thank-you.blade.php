<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tanggapan Terkirim</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gform-light/20 min-h-screen flex items-center justify-center">
    <div class="max-w-lg mx-auto px-4 text-center">
        <div class="bg-white rounded-2xl border border-gray-200 p-10 shadow-sm">
            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-gray-800 mb-2">Terima Kasih!</h1>
            <p class="text-gray-600 mb-1">Tanggapan Anda telah berhasil disimpan.</p>
            @if(session('form_title'))
                <p class="text-sm text-gray-500">Formulir: {{ session('form_title') }}</p>
            @endif
            <div class="mt-8">
                <a href="{{ route('home') }}" class="text-gform hover:text-gform-dark font-medium text-sm transition">
                    ← Kembali ke Beranda
                </a>
            </div>
        </div>
        <p class="text-xs text-gray-400 mt-6">
            Dibuat dengan <a href="{{ route('home') }}" class="text-gform hover:underline">FormClone</a>
        </p>
    </div>
</body>
</html>
