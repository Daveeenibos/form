<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tanggapan Terkirim</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes scaleIn {
            from { opacity: 0; transform: scale(0.5); }
            to { opacity: 1; transform: scale(1); }
        }
        @keyframes pulseGlow {
            0%, 100% { box-shadow: 0 0 0 0 rgba(37, 211, 102, 0.4); }
            50% { box-shadow: 0 0 0 12px rgba(37, 211, 102, 0); }
        }
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            15%, 45%, 75% { transform: translateX(-4px); }
            30%, 60%, 90% { transform: translateX(4px); }
        }

        .card-animate { animation: fadeInUp 0.6s ease-out; }
        .icon-animate { animation: scaleIn 0.5s ease-out 0.3s both; }
        .alert-animate { animation: slideDown 0.5s ease-out 0.6s both; }
        .btn-wa {
            animation: pulseGlow 2s ease-in-out infinite;
            background: linear-gradient(135deg, #25D366 0%, #128C7E 100%);
            transition: all 0.3s ease;
        }
        .btn-wa:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(37, 211, 102, 0.4);
            background: linear-gradient(135deg, #1DA851 0%, #0E7A6E 100%);
        }
        .alert-box {
            background: linear-gradient(135deg, #FFF7ED 0%, #FFEDD5 100%);
            border-left: 4px solid #F97316;
        }
        .warning-icon {
            animation: shake 0.8s ease-in-out 1.2s both;
        }
    </style>
</head>
<body style="background: linear-gradient(135deg, #f0f4ff 0%, #e8f5e9 100%); min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 16px;">

    @php
        $formTitle = session('form_title', 'Formulir');
        $formCategory = session('form_category');
        $waMessage = "Halo, saya ingin mengkonfirmasi bahwa saya telah mengisi formulir \"{$formTitle}\"";
        if ($formCategory) {
            $waMessage .= " pada kategori {$formCategory}";
        }
        $waMessage .= ". Mohon untuk ditindaklanjuti. Terima kasih.";
        $waUrl = "https://wa.me/628114749111?text=" . urlencode($waMessage);
    @endphp

    <div style="max-width: 480px; width: 100%;">
        {{-- Success Card --}}
        <div class="card-animate" style="background: #fff; border-radius: 20px; padding: 40px 32px 32px; text-align: center; box-shadow: 0 4px 24px rgba(0,0,0,0.08); margin-bottom: 16px;">
            {{-- Check Icon --}}
            <div class="icon-animate" style="width: 72px; height: 72px; border-radius: 50%; background: linear-gradient(135deg, #22c55e, #16a34a); display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                <svg width="36" height="36" fill="none" stroke="#fff" stroke-width="3" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <h1 style="font-size: 26px; font-weight: 800; color: #1a1a1a; margin: 0 0 8px;">Terima Kasih!</h1>
            <p style="font-size: 15px; color: #6b7280; margin: 0 0 4px;">Tanggapan Anda telah berhasil disimpan.</p>
            @if(session('form_title'))
                <p style="font-size: 13px; color: #9ca3af;">Formulir: <strong>{{ session('form_title') }}</strong></p>
            @endif
        </div>

        {{-- WhatsApp Alert Card --}}
        <div class="alert-animate" style="background: #fff; border-radius: 20px; padding: 0; box-shadow: 0 4px 24px rgba(0,0,0,0.08); overflow: hidden;">
            {{-- Warning Header --}}
            <div class="alert-box" style="padding: 16px 20px; display: flex; align-items: flex-start; gap: 12px;">
                <div class="warning-icon" style="flex-shrink: 0; width: 36px; height: 36px; background: #F97316; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-top: 2px;">
                    <svg width="20" height="20" fill="#fff" viewBox="0 0 24 24">
                        <path d="M12 2L1 21h22L12 2zm0 4l7.53 13H4.47L12 6zm-1 5v4h2v-4h-2zm0 6v2h2v-2h-2z"/>
                    </svg>
                </div>
                <div>
                    <p style="font-size: 14px; font-weight: 700; color: #C2410C; margin: 0 0 4px;">⚠️ Konfirmasi Wajib via WhatsApp</p>
                    <p style="font-size: 13px; color: #9A3412; margin: 0; line-height: 1.5;">
                        Permintaan Anda <strong>tidak akan diproses</strong> jika tidak melakukan konfirmasi melalui WhatsApp. Silakan klik tombol di bawah untuk mengirim konfirmasi.
                    </p>
                </div>
            </div>

            {{-- WhatsApp Button Area --}}
            <div style="padding: 20px 24px 28px; text-align: center;">
                <a href="{{ $waUrl }}" target="_blank" rel="noopener noreferrer" class="btn-wa"
                   style="display: inline-flex; align-items: center; justify-content: center; gap: 10px; width: 100%; padding: 14px 24px; color: #fff; border-radius: 14px; font-size: 15px; font-weight: 700; text-decoration: none; letter-spacing: 0.3px;">
                    <svg width="22" height="22" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                    </svg>
                    Konfirmasi via WhatsApp
                </a>
                <p style="font-size: 11px; color: #9ca3af; margin: 12px 0 0;">Anda akan diarahkan ke WhatsApp dengan pesan otomatis</p>
            </div>
        </div>

        {{-- Back Link --}}
        <div style="text-align: center; margin-top: 20px;">
            <a href="{{ route('home') }}" style="font-size: 13px; color: #6b7280; text-decoration: none;">← Kembali ke Beranda</a>
        </div>
    </div>
</body>
</html>
