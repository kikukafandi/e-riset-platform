<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Persetujuan Riset</title>
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
            background: #f9f9f9;
            border: 1px solid #ddd;
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
        
        .qr-box {
            display: inline-block;
            border: 1px solid #000;
            padding: 8px;
            border-radius: 4px;
        }
        
        .conditions {
            margin: 30px 0;
            padding: 20px;
            background: #f0f8ff;
            border: 1px solid #4a90e2;
            border-radius: 5px;
        }
        
        .conditions h4 {
            margin-top: 0;
            color: #2c5aa0;
        }
        
        .conditions ol {
            padding-left: 20px;
        }
        
        .conditions li {
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
                <td>: 1 (satu) berkas</td>
            </tr>
            <tr>
                <td class="label">Hal</td>
                <td>: <strong>Persetujuan Pelaksanaan Riset</strong></td>
            </tr>
        </table>
    </div>

    <div class="content">
        <p>Kepada Yth.<br>
        <strong>{{ $applicant_name }}</strong><br>
        {{ $applicant_institution }}<br>
        di tempat</p>

        <p>Dengan hormat,</p>

        <p>Mengacu pada permohonan Saudara untuk melakukan kegiatan penelitian/riset di lingkungan Direktorat Jenderal Bea dan Cukai, dengan ini kami menyampaikan bahwa permohonan tersebut telah disetujui dengan ketentuan sebagai berikut:</p>

        <div class="research-details">
            <h4 style="margin-top: 0; text-align: center;">RINCIAN PERSETUJUAN RISET</h4>
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
                    <td class="detail-label">Lokasi Penelitian</td>
                    <td>: {{ $office_destination }} ({{ $office_code }})</td>
                </tr>
                <tr>
                    <td class="detail-label">Periode Pelaksanaan</td>
                    <td>: {{ $research_period }}</td>
                </tr>
                @if($paper_title)
                <tr>
                    <td class="detail-label">Judul Paper</td>
                    <td>: {{ $paper_title }}</td>
                </tr>
                @endif
                @if($doi_number)
                <tr>
                    <td class="detail-label">DOI Number</td>
                    <td>: {{ $doi_number }}</td>
                </tr>
                @endif
                <tr>
                    <td class="detail-label">Tanggal Verifikasi</td>
                    <td>: {{ $verification_date }}</td>
                </tr>
            </table>
        </div>

        <div class="conditions">
            <h4>KETENTUAN DAN KEWAJIBAN:</h4>
            <ol>
                <li>Peneliti wajib menghormati dan mematuhi seluruh peraturan yang berlaku di lingkungan Direktorat Jenderal Bea dan Cukai.</li>
                <li>Peneliti wajib menjaga kerahasiaan data dan informasi yang diperoleh selama proses penelitian.</li>
                <li>Peneliti dilarang mengambil foto, video, atau merekam kegiatan operasional tanpa izin tertulis dari pejabat yang berwenang.</li>
                <li>Hasil penelitian harus diserahkan kepada Direktorat Jenderal Bea dan Cukai dalam bentuk soft copy dan hard copy.</li>
                <li>Publikasi hasil penelitian harus mendapat persetujuan tertulis dari Direktorat Jenderal Bea dan Cukai.</li>
                <li>Peneliti bertanggung jawab penuh atas segala risiko yang timbul selama pelaksanaan penelitian.</li>
                <li>Surat persetujuan ini berlaku selama periode yang telah ditentukan dan dapat dicabut sewaktu-waktu jika terdapat pelanggaran.</li>
            </ol>
        </div>

        <p>Demikian surat persetujuan ini dibuat untuk dipergunakan sebagaimana mestinya. Atas perhatian dan kerjasamanya, kami ucapkan terima kasih.</p>

        @if($verification_message)
        <div style="margin: 20px 0; padding: 15px; background: #e8f5e8; border: 1px solid #4caf50; border-radius: 5px;">
            <h4 style="margin-top: 0; color: #2e7d32;">Catatan Verifikator:</h4>
            <p style="font-style: italic; margin-bottom: 0;">{{ $verification_message }}</p>
        </div>
        @endif
    </div>

    <div class="signature-section">
        <div class="signature-box">
            <p>Jakarta, {{ $date }}</p>
            <p><strong>Direktur Jenderal Bea dan Cukai</strong><br>
            <strong>u.b. Kepala Bagian Hubungan Masyarakat</strong></p>
            <div class="qr-box">
                <img src="{{ $qr_url }}" alt="QR Verifikasi" width="160" height="160">
            </div>
            <p style="margin-top:10px"><strong>TTE & Verifikasi</strong></p>
            <p>Scan QR untuk verifikasi dokumen</p>
            <p><strong>Dr. Ahmad Syarif, M.Si.</strong><br>
            NIP. 197508151998031001</p>
        </div>
    </div>

    <div style="margin-top: 40px; padding: 15px; background: #fff3cd; border: 1px solid #ffc107; border-radius: 5px;">
        <h5 style="margin-top: 0; color: #856404;">PENTING:</h5>
        <p style="font-size: 12px; margin-bottom: 0; color: #856404;">
            Surat ini digenerate secara otomatis melalui sistem E-Riset Platform. 
            Untuk verifikasi keaslian dokumen, silakan hubungi Bagian Hubungan Masyarakat DJBC 
            atau kunjungi portal resmi di <strong>www.beacukai.go.id</strong>
        </p>
    </div>
</body>
</html>