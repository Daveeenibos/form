<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FormClone - Buat Formulir Online</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-white">
    <div class="min-h-screen flex flex-col">
        <nav class="px-6 lg:px-12 py-4 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <svg class="w-8 h-8 text-gform" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M14 2H6c-1.1 0-2 .9-2 2v16c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zM6 20V4h7v5h5v11H6z"/>
                    <path d="M8 15.01V17h2v-1.99H8zm0-4V13h2v-1.99H8zm0-4V9h2V7.01H8zM12 17h4v-2h-4v2zm0-4h4v-2h-4v2zm0-4h4V7h-4v2z"/>
                </svg>
                <span class="text-xl font-bold text-gray-800">FormClone</span>
            </div>
            <div class="flex items-center gap-3">
                @auth
                    <a href="{{ route('dashboard') }}" class="px-5 py-2.5 bg-gform text-white rounded-full text-sm font-medium hover:bg-gform-dark transition shadow-md hover:shadow-lg">Ke Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="px-5 py-2.5 text-gray-600 hover:text-gray-800 text-sm font-medium transition">Masuk</a>
                    <a href="{{ route('register') }}" class="px-5 py-2.5 bg-gform text-white rounded-full text-sm font-medium hover:bg-gform-dark transition shadow-md hover:shadow-lg">Daftar Gratis</a>
                @endauth
            </div>
        </nav>

        <div class="flex-1 flex items-center">
            <div class="max-w-6xl mx-auto px-6 lg:px-12 py-16 grid lg:grid-cols-2 gap-12 items-center">
                <div>
                    <h1 class="text-5xl lg:text-6xl font-extrabold text-gray-900 leading-tight">
                        Buat <span class="text-gform">formulir</span> dengan mudah
                    </h1>
                    <p class="mt-6 text-lg text-gray-600 leading-relaxed">
                        Buat survei, kuis, dan polling dengan pembuat formulir yang intuitif.
                        Kumpulkan jawaban dan analisis hasilnya — semuanya gratis.
                    </p>
                    <div class="mt-8 flex flex-col sm:flex-row gap-3">
                        <a href="{{ route('register') }}" class="px-8 py-3.5 bg-gform text-white rounded-full text-base font-semibold hover:bg-gform-dark transition shadow-lg hover:shadow-xl text-center">
                            Mulai Buat Formulir
                        </a>
                    </div>
                    <div class="mt-8 flex items-center gap-6 text-sm text-gray-500">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            Gratis selamanya
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            Formulir tak terbatas
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            Ekspor ke CSV
                        </div>
                    </div>
                </div>
                <div class="hidden lg:block">
                    <div class="bg-white rounded-2xl shadow-2xl border border-gray-100 p-8 transform rotate-1 hover:rotate-0 transition-transform duration-500">
                        <div class="h-3 rounded-t-lg bg-gform mb-6"></div>
                        <div class="space-y-4">
                            <div class="h-6 bg-gray-200 rounded w-3/4"></div>
                            <div class="h-4 bg-gray-100 rounded w-1/2"></div>
                            <div class="mt-6 space-y-3">
                                <div class="p-4 bg-white border border-gray-200 rounded-lg">
                                    <div class="h-4 bg-gray-200 rounded w-2/3 mb-3"></div>
                                    <div class="h-10 bg-gray-50 rounded border border-gray-200"></div>
                                </div>
                                <div class="p-4 bg-white border border-gray-200 rounded-lg">
                                    <div class="h-4 bg-gray-200 rounded w-1/2 mb-3"></div>
                                    <div class="space-y-2">
                                        <div class="flex items-center gap-2">
                                            <div class="w-4 h-4 rounded-full border-2 border-gform"></div>
                                            <div class="h-3 bg-gray-100 rounded w-24"></div>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <div class="w-4 h-4 rounded-full border-2 border-gray-300"></div>
                                            <div class="h-3 bg-gray-100 rounded w-32"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4 flex justify-end">
                                <div class="px-6 py-2 bg-gform rounded-md text-white text-sm font-medium">Kirim</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
