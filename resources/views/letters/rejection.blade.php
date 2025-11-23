<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Penolakan Riset</title>
    <style>
        body {
            font-family: 'Times New Roman', serif;
            line-height: 1.6;
            margin: 0;
            padding: 40px;
            background: white;
        }
        
        .letterhead {
            text-align: center;
            border-bottom: 3px solid #000;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        
        .letterhead h1 {
            font-size: 18px;
            margin: 5px 0;
            font-weight: bold;
        }
        
        .letterhead h2 {
            font-size: 16px;
            margin: 5px 0;
            font-weight: bold;
        }
        
        .letterhead p {
            font-size: 12px;
            margin: 3px 0;
        }
        
        .document-info {
            margin-bottom: 30px;
        }
        
        .document-info table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .document-info td {
            padding: 5px 0;
            vertical-align: top;
        }
        
        .document-info .label {
            width: 150px;
            font-weight: bold;
        }
        
        .content {
            text-align: justify;
            margin-bottom: 40px;
        }
        
        .content p {
            margin: 15px 0;
        }
        
        .research-details {
            margin: 20px 0;
            padding: 15px;
            background: #fff5f5;
            border: 1px solid #dc3545;
        }
        
        .research-details table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .research-details td {
            padding: 8px 0;
            vertical-align: top;
        }
        
        .research-details .detail-label {
            width: 200px;
            font-weight: bold;
        }
        
        .signature-section {
            margin-top: 50px;
            text-align: right;
        }
        
        .signature-box {
            display: inline-block;
            text-align: center;
            margin-left: 100px;
        }
        
        .signature-space {
            height: 80px;
            width: 200px;
            border-bottom: 1px solid #000;
            margin: 20px auto;
        }
        
        .rejection-reason {
            margin: 30px 0;
            padding: 20px;
            background: #ffebee;
            border: 1px solid #dc3545;
            border-radius: 5px;
        }
        
        .rejection-reason h4 {
            margin-top: 0;
            color: #c62828;
        }
        
        .suggestions {
            margin: 30px 0;
            padding: 20px;
            background: #f3e5f5;
            border: 1px solid #9c27b0;
            border-radius: 5px;
        }
        
        .suggestions h4 {
            margin-top: 0;
            color: #7b1fa2;
        }
        
        .suggestions ol {
            padding-left: 20px;
        }
        
        .suggestions li {
            margin: 8px 0;
        }
        
        @media print {
            body {
                padding: 20px;
            }
            
            .signature-space {
                height: 60px;
            }
        }
    </style>
</head>
<body>
    <div class="letterhead">
        <h1>KEMENTERIAN KEUANGAN REPUBLIK INDONESIA</h1>
        <h2>DIREKTORAT JENDERAL BEA DAN CUKAI</h2>
        <h2>KANTOR PUSAT</h2>
        <p>Jl. Jenderal Ahmad Yani, By Pass, Jakarta 13230</p>
        <p>Telp: (021) 489-0308, Fax: (021) 489-5618</p>
        <p>Website: www.beacukai.go.id, Email: info@customs.go.id</p>
    </div>

    <div class="document-info">
        <table>
            <tr>
                <td class="label">Nomor</td>
                <td>: {{ $document_number }}</td>
            </tr>
            <tr>
                <td class="label">Tanggal</td>
                <td>: {{ $date }}</td>
            </tr>
            <tr>
                <td class="label">Sifat</td>
                <td>: Penting</td>
            </tr>
            <tr>
                <td class="label">Lampiran</td>
                <td>: -</td>
            </tr>
            <tr>
                <td class="label">Hal</td>
                <td>: <strong>Penolakan Permohonan Riset</strong></td>
            </tr>
        </table>
    </div>

    <div class="content">
        <p>Kepada Yth.<br>
        <strong>{{ $applicant_name }}</strong><br>
        {{ $applicant_institution }}<br>
        di tempat</p>

        <p>Dengan hormat,</p>

        <p>Mengacu pada permohonan Saudara untuk melakukan kegiatan penelitian/riset di lingkungan Direktorat Jenderal Bea dan Cukai, setelah dilakukan kajian dan evaluasi, dengan ini kami menyampaikan bahwa permohonan tersebut <strong>tidak dapat disetujui</strong> pada saat ini.</p>

        <div class="research-details">
            <h4 style="margin-top: 0; text-align: center; color: #dc3545;">RINCIAN PERMOHONAN YANG DITOLAK</h4>
            <table>
                <tr>
                    <td class="detail-label">Judul Penelitian</td>
                    <td>: {{ $research_title }}</td>
                </tr>
                <tr>
                    <td class="detail-label">Topik Riset</td>
                    <td>: {{ $research_topic }}</td>
                </tr>
                <tr>
                    <td class="detail-label">Pemohon</td>
                    <td>: {{ $applicant_name }}</td>
                </tr>
                <tr>
                    <td class="detail-label">Instansi</td>
                    <td>: {{ $applicant_institution }}</td>
                </tr>
                <tr>
                    <td class="detail-label">Tanggal Verifikasi</td>
                    <td>: {{ $verification_date }}</td>
                </tr>
            </table>
        </div>

        @if($rejection_reason)
        <div class="rejection-reason">
            <h4>ALASAN PENOLAKAN:</h4>
            <p>{{ $rejection_reason }}</p>
        </div>
        @endif

        <div class="suggestions">
            <h4>SARAN DAN REKOMENDASI:</h4>
            <ol>
                <li>Perbaiki dan lengkapi dokumen permohonan sesuai dengan persyaratan yang berlaku.</li>
                <li>Pastikan topik penelitian sesuai dengan bidang kerja Direktorat Jenderal Bea dan Cukai.</li>
                <li>Lakukan koordinasi terlebih dahulu dengan Bagian Hubungan Masyarakat untuk konsultasi proposal.</li>
                <li>Sertakan surat pengantar resmi dari instansi induk (jika berlaku).</li>
                <li>Saudara dapat mengajukan permohonan kembali setelah melakukan perbaikan-perbaikan yang diperlukan.</li>
            </ol>
        </div>

        <p>Keputusan ini diambil berdasarkan pertimbangan teknis dan kebijakan organisasi. Kami menghargai minat Saudara untuk melakukan penelitian di bidang kepabeanan dan cukai, dan mengharapkan Saudara dapat melengkapi persyaratan untuk pengajuan di masa mendatang.</p>

        <p>Demikian surat pemberitahuan ini dibuat untuk dipergunakan sebagaimana mestinya. Atas perhatian dan pengertiannya, kami ucapkan terima kasih.</p>
    </div>

    <div class="signature-section">
        <div class="signature-box">
            <p>Jakarta, {{ $date }}</p>
            <p><strong>Direktur Jenderal Bea dan Cukai</strong><br>
            <strong>u.b. Kepala Bagian Hubungan Masyarakat</strong></p>
            <div class="signature-space"></div>
            <p><strong>Dr. Ahmad Syarif, M.Si.</strong><br>
            NIP. 197508151998031001</p>
        </div>
    </div>

    <div style="margin-top: 40px; padding: 15px; background: #e3f2fd; border: 1px solid #2196f3; border-radius: 5px;">
        <h5 style="margin-top: 0; color: #0d47a1;">KONTAK LEBIH LANJUT:</h5>
        <p style="font-size: 12px; margin-bottom: 0; color: #0d47a1;">
            Untuk informasi lebih lanjut atau konsultasi mengenai persyaratan riset, 
            silakan menghubungi Bagian Hubungan Masyarakat DJBC di:<br>
            <strong>Telp:</strong> (021) 489-0308 <strong>|</strong> 
            <strong>Email:</strong> info@customs.go.id <strong>|</strong> 
            <strong>Website:</strong> www.beacukai.go.id
        </p>
    </div>

    <div style="margin-top: 20px; padding: 15px; background: #fff3cd; border: 1px solid #ffc107; border-radius: 5px;">
        <h5 style="margin-top: 0; color: #856404;">PENTING:</h5>
        <p style="font-size: 12px; margin-bottom: 0; color: #856404;">
            Surat ini digenerate secara otomatis melalui sistem E-Riset Platform. 
            Untuk verifikasi keaslian dokumen, silakan hubungi Bagian Hubungan Masyarakat DJBC 
            atau kunjungi portal resmi di <strong>www.beacukai.go.id</strong>
        </p>
    </div>
</body>
</html>