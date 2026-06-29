<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #333; }

        .header { display: flex; justify-content: space-between; align-items: center; padding: 24px; }
        .header img { width: 48px; height: 48px; }
        .header-right { text-align: right; }
        .header-right table { margin-left: auto; }
        .header-right td { padding: 2px 0; font-size: 12px; }
        .header-right td:first-child { font-weight: bold; padding-right: 32px; }

        .divider { height: 1px; background: #d1d5db; margin: 0; }

        .info-grid { display: table; width: 100%; padding: 24px; }
        .info-row { display: table-row; }
        .info-cell { display: table-cell; width: 50%; padding-bottom: 10px; vertical-align: top; }
        .info-label { font-size: 10px; color: #6b7280; margin-bottom: 2px; }
        .info-value { font-size: 12px; }

        .section-header { padding: 10px 24px; border-top: 1px solid #d1d5db; border-bottom: 1px solid #d1d5db; }
        .section-header table { width: 100%; }
        .section-header td { font-size: 12px; font-weight: bold; width: 33.33%; }

        .section-body { padding: 8px 24px 24px; }
        .columns-table { width: 100%; margin-bottom: 16px; }
        .columns-table td { width: 33.33%; vertical-align: top; padding-right: 16px; }

        .item-row { display: flex; justify-content: space-between; padding: 3px 0; font-size: 12px; }
        .item-table { width: 100%; }
        .item-table tr td { padding: 3px 0; font-size: 12px; }
        .item-table tr td:last-child { text-align: right; }

        .total-row { border-top: 1px solid #d1d5db; padding-top: 8px; margin-top: 4px; }
        .total-table { width: 100%; }
        .total-table td { padding: 4px 0; font-weight: bold; font-size: 12px; }
        .total-table td:last-child { text-align: right; }

        .footer { padding: 14px 28px; border-top: 1px solid #d1d5db; }
        .footer table { width: 100%; }
        .footer td { font-size: 10px; color: #9ca3af; vertical-align: bottom; }
        .footer td:last-child { text-align: right; }
        .footer .sign-space { margin-top: 64px; font-weight: 500; }

        .empty-note { text-align: center; color: #9ca3af; font-size: 10px; padding: 12px 0; }
    </style>
</head>
<body>

 Header
<div class="header">
    <div>
        <img src="https://www.digitalpowertalent.com/images/logo.png" alt="Logo">
    </div>
    <div class="header-right">
        <table>
            <tr>
                <td>Tanggal</td>
                <td>{{ \Carbon\Carbon::parse($payroll->payday)->translatedFormat('d F Y') }}</td>
            </tr>
            <tr>
                <td>No. Slip Gaji</td>
                <td>{{ $payroll->id }}</td>
            </tr>
        </table>
    </div>
</div>

<div class="divider"></div>

 Info Pegawai
<table style="width:100%; padding: 24px;">
    <tr>
        <td style="width:50%; padding-bottom:10px; vertical-align:top;">
            <div class="info-label">Nama Pegawai</div>
            <div class="info-value">{{ $payroll->employee->name }}</div>
        </td>
        <td style="width:50%; padding-bottom:10px; vertical-align:top;">
            <div class="info-label">Jabatan</div>
            <div class="info-value">{{ $payroll->position }}</div>
        </td>
    </tr>
    <tr>
        <td style="vertical-align:top;">
            <div class="info-label">Alamat</div>
            <div class="info-value">{{ $payroll->employee->address }}</div>
        </td>
        <td style="vertical-align:top;">
            <div class="info-label">Periode</div>
            <div class="info-value">
                {{ DateTime::createFromFormat('!m', $payroll->monthly_period)->format('F') }}
                {{ $payroll->year_period }}
            </div>
        </td>
    </tr>
</table>

 Section Header
<table style="width:100%; padding: 10px 24px; border-top: 1px solid #d1d5db; border-bottom: 1px solid #d1d5db;">
    <tr>
        <td style="width:33.33%; font-weight:bold; font-size:12px; padding: 10px 24px 10px 0;">Absensi</td>
        <td style="width:33.33%; font-weight:bold; font-size:12px;">Pendapatan</td>
        <td style="width:33.33%; font-weight:bold; font-size:12px;">Potongan</td>
    </tr>
</table>

 Section Body
<table style="width:100%; padding: 8px 24px 24px; margin-top:4px;">
    <tr>
         Absensi
        <td style="width:33.33%; vertical-align:top; padding: 0 16px 0 24px;">
            <table style="width:100%;">
                <tr><td style="font-size:12px; padding:3px 0;">Hadir</td><td style="text-align:right; font-size:12px;">{{ $attendances->where('hadir', true)->count() }} hari</td></tr>
                <tr><td style="font-size:12px; padding:3px 0;">Sakit</td><td style="text-align:right; font-size:12px;">{{ $attendances->where('sakit', true)->count() }} hari</td></tr>
                <tr><td style="font-size:12px; padding:3px 0;">Izin</td><td style="text-align:right; font-size:12px;">{{ $attendances->where('izin', true)->count() }} hari</td></tr>
                <tr><td style="font-size:12px; padding:3px 0;">Alfa</td><td style="text-align:right; font-size:12px;">{{ $attendances->where('alpa', true)->count() }} hari</td></tr>
            </table>
        </td>

         Pendapatan
        <td style="width:33.33%; vertical-align:top; padding: 0 16px 0 0;">
            <table style="width:100%;">
                <tr>
                    <td style="font-size:12px; padding:3px 0;">Gaji Pokok</td>
                    <td style="text-align:right; font-size:12px;">Rp{{ number_format($payroll->salary, 0, ',', '.') }}</td>
                </tr>
                @foreach ($payroll->payrollItems->where('type', '!=', 'deduction') as $item)
                    <tr>
                        <td style="font-size:12px; padding:3px 0;">{{ $item->name }}</td>
                        <td style="text-align:right; font-size:12px;">+ Rp{{ number_format($item->amount, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </table>
        </td>

         Potongan
        <td style="width:33.33%; vertical-align:top; padding: 0;">
            <table style="width:100%;">
                @forelse ($payroll->payrollItems->where('type', 'deduction') as $item)
                    <tr>
                        <td style="font-size:12px; padding:3px 0;">{{ $item->name }}</td>
                        <td style="text-align:right; font-size:12px;">- Rp{{ number_format($item->amount, 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="2" style="font-size:10px; color:#9ca3af; text-align:center; padding: 12px 0;">Tidak ada potongan</td></tr>
                @endforelse
            </table>
        </td>
    </tr>
</table>

 Total
<table style="width:100%; padding: 0 24px 24px; border-top: 1px solid #d1d5db; margin: 0 0 0 0;">
    <tr>
        <td style="font-weight:bold; font-size:12px; padding: 8px 0 0 24px;">Total Gaji Diterima</td>
        <td style="font-weight:bold; font-size:12px; text-align:right; padding: 8px 24px 0 0;">Rp{{ number_format($payroll->total, 0, ',', '.') }}</td>
    </tr>
</table>

 Footer
<table style="width:100%; padding: 14px 28px; border-top: 1px solid #d1d5db; margin-top: 16px;">
    <tr>
        <td style="font-size:10px; color:#9ca3af; vertical-align:bottom;">
            <div>Dicetak pada {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</div>
            <div>Dokumen ini digenerate secara otomatis.</div>
        </td>
        <td style="font-size:10px; color:#9ca3af; text-align:right; vertical-align:bottom;">
            <div>Menyetujui,</div>
            <div style="margin-top:64px; font-weight:500;">HRD / Pimpinan</div>
        </td>
    </tr>
</table>

</body>
</html>
