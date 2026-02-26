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
            50% { box-shadow: 0 0 0 14px rgba(37, 211, 102, 0); }
        }
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes shake {
            0%, 100% { transform: rotate(0deg); }
            20% { transform: rotate(-8deg); }
            40% { transform: rotate(8deg); }
            60% { transform: rotate(-5deg); }
            80% { transform: rotate(5deg); }
        }
        @keyframes borderPulse {
            0%, 100% { border-color: #F97316; }
            50% { border-color: #FB923C; }
        }

        .card-animate { animation: fadeInUp 0.6s ease-out; }
        .icon-animate { animation: scaleIn 0.5s ease-out 0.3s both; }
        .alert-animate { animation: slideDown 0.5s ease-out 0.5s both; }
        .code-animate { animation: scaleIn 0.4s ease-out 0.8s both; }
        .btn-animate { animation: fadeInUp 0.5s ease-out 1s both; }

        .btn-wa {
            animation: pulseGlow 2s ease-in-out infinite 1.2s;
            background: linear-gradient(135deg, #25D366 0%, #128C7E 100%);
            transition: all 0.3s ease;
        }
        .btn-wa:hover {
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 8px 30px rgba(37, 211, 102, 0.45);
            background: linear-gradient(135deg, #1EB853 0%, #0E7A6E 100%);
        }

        .warning-card {
            border: 2px solid #F97316;
            animation: borderPulse 2s ease-in-out infinite;
        }

        .warning-icon {
            animation: shake 0.6s ease-in-out 1.2s both;
        }

        .code-box {
            background: linear-gradient(135deg, #F0FDF4, #DCFCE7);
            border: 2px dashed #22C55E;
        }

        .code-text {
            font-family: 'Courier New', monospace;
            letter-spacing: 3px;
        }
    </style>
</head>
<body style="background: linear-gradient(135deg, #f0f4ff 0%, #e8f5e9 100%); min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 16px;">

    @php
        $formTitle = session('form_title', 'Formulir');
        $formCategory = session('form_category');
        $confirmCode = session('confirmation_code', '-');
        $waMessage = "Halo, saya ingin mengkonfirmasi bahwa saya telah mengisi formulir \"{$formTitle}\"";
        if ($formCategory) {
            $waMessage .= " pada kategori {$formCategory}";
        }
        $waMessage .= " dengan kode konfirmasi: {$confirmCode}. Mohon untuk ditindaklanjuti. Terima kasih.";
        $waUrl = "https://wa.me/628114749111?text=" . urlencode($waMessage);
    @endphp

    <div style="max-width: 480px; width: 100%;">

        {{-- ✅ Success Card --}}
        <div class="card-animate" style="background: #fff; border-radius: 20px; padding: 36px 28px 28px; text-align: center; box-shadow: 0 4px 24px rgba(0,0,0,0.06); margin-bottom: 16px;">
            <div class="icon-animate" style="width: 68px; height: 68px; border-radius: 50%; background: linear-gradient(135deg, #22c55e, #16a34a); display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
                <svg width="34" height="34" fill="none" stroke="#fff" stroke-width="3" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <h1 style="font-size: 24px; font-weight: 800; color: #1a1a1a; margin: 0 0 6px;">Terima Kasih!</h1>
            <p style="font-size: 14px; color: #6b7280; margin: 0;">Tanggapan Anda telah berhasil disimpan.</p>
            @if(session('form_title'))
                <p style="font-size: 13px; color: #9ca3af; margin: 6px 0 0;">Formulir: <strong>{{ session('form_title') }}</strong></p>
            @endif

            {{-- Confirmation Code --}}
            <div class="code-animate" style="margin-top: 20px;">
                <p style="font-size: 11px; color: #6b7280; margin: 0 0 8px; text-transform: uppercase; font-weight: 600; letter-spacing: 1px;">Kode Konfirmasi Anda</p>
                <div class="code-box" style="display: inline-block; padding: 12px 28px; border-radius: 12px;">
                    <span class="code-text" style="font-size: 22px; font-weight: 800; color: #16a34a;">{{ $confirmCode }}</span>
                </div>
            </div>
        </div>

        {{-- ⚠️ Warning Alert Card --}}
        <div class="alert-animate warning-card" style="background: #fff; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,0.06);">
            {{-- Warning Header --}}
            <div style="background: linear-gradient(135deg, #FFF7ED, #FFEDD5); padding: 16px 20px; display: flex; align-items: flex-start; gap: 12px;">
                <div class="warning-icon" style="flex-shrink: 0; width: 40px; height: 40px; background: linear-gradient(135deg, #F97316, #EA580C); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                    <svg width="22" height="22" fill="#fff" viewBox="0 0 24 24">
                        <path d="M1 21h22L12 2 1 21zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z"/>
                    </svg>
                </div>
                <div>
                    <p style="font-size: 15px; font-weight: 700; color: #C2410C; margin: 0 0 6px;">⚠️ Langkah Wajib!</p>
                    <p style="font-size: 13px; color: #9A3412; margin: 0; line-height: 1.6;">
                        Kirim <strong>kode konfirmasi</strong> di atas melalui WhatsApp untuk memproses permintaan Anda.
                        <br><br>
                        <span style="background: #FED7AA; padding: 3px 8px; border-radius: 6px; font-weight: 700; font-size: 12px;">
                            ❌ Tanpa konfirmasi = permintaan TIDAK akan diproses
                        </span>
                    </p>
                </div>
            </div>

            {{-- WhatsApp Button --}}
            <div class="btn-animate" style="padding: 20px 24px 28px; text-align: center;">
                <a href="{{ $waUrl }}" target="_blank" rel="noopener noreferrer" class="btn-wa"
                   style="display: inline-flex; align-items: center; justify-content: center; gap: 10px; width: 100%; padding: 16px 24px; color: #fff; border-radius: 14px; font-size: 15px; font-weight: 700; text-decoration: none;">
                    <svg width="22" height="22" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                    </svg>
                    Kirim Konfirmasi via WhatsApp
                </a>
                <p style="font-size: 11px; color: #9ca3af; margin: 12px 0 0;">Pesan konfirmasi akan terisi otomatis beserta kode Anda</p>
            </div>
        </div>

        {{-- Back Link --}}
        <div style="text-align: center; margin-top: 20px;">
            <a href="{{ route('home') }}" style="font-size: 13px; color: #6b7280; text-decoration: none;">← Kembali ke Beranda</a>
        </div>
    </div>
</body>
</html>
