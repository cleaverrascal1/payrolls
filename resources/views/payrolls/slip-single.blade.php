<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: DejaVu Sans, sans-serif; font-size: 13px; color: #111827; background: #fff; }

        .card { border: 1px solid #d1d5db; border-radius: 12px; overflow: hidden; }

        .header-table { width: 100%; padding: 24px; }
        .header-table td { vertical-align: middle; }

        .header-meta { width: auto; margin-left: auto; }
        .header-meta td { font-size: 12px; padding: 2px 0; }
        .header-meta td:first-child { font-weight: bold; padding-right: 32px; }

        .divider { height: 1px; background: #d1d5db; }

        .info-table { width: 100%; padding: 24px; }
        .info-table td { width: 50%; padding-bottom: 12px; vertical-align: top; }
        .info-label { font-size: 11px; color: #6b7280; margin-bottom: 2px; }
        .info-value { font-size: 13px; }

        .section-header-table { width: 100%; border-top: 1px solid #d1d5db; border-bottom: 1px solid #d1d5db; }
        .section-header-table td { padding: 10px 0; font-size: 13px; font-weight: bold; width: 33.33%; }
        .section-header-table td:first-child { padding-left: 24px; }
        .section-header-table td:nth-child(2),
        .section-header-table td:nth-child(3) { padding-left: 8px; }

        .columns-table { width: 100%; padding: 8px 24px 0; }
        .columns-table > tbody > tr > td { width: 33.33%; vertical-align: top; padding-top: 8px; padding-right: 16px; }

        .item-table { width: 100%; }
        .item-table td { font-size: 12px; padding: 3px 0; }
        .item-table td:last-child { text-align: right; white-space: nowrap; }

        .empty-note { font-size: 10px; color: #9ca3af; text-align: center; padding: 16px 0; }

        .total-wrapper { padding: 8px 24px 24px; }
        .total-table { width: 100%; border-top: 1px solid #d1d5db; }
        .total-table td { font-weight: bold; font-size: 13px; padding-top: 8px; }
        .total-table td:last-child { text-align: right; }

        .footer-table { width: 100%; padding: 14px 28px; border-top: 1px solid #d1d5db; }
        .footer-table td { font-size: 10px; color: #9ca3af; vertical-align: bottom; }
        .footer-table td:last-child { text-align: right; }
        .sign-space { margin-top: 60px; font-weight: 500; font-size: 12px; color: #9ca3af; }
    </style>
</head>
<body>
<div class="card">

    {{-- HEADER --}}
    <table class="header-table">
        <tr>
            <td>
                <img src="{{ $logoSrc }}" alt="Logo" style="width:48px; height:48px;">
            </td>
            <td style="text-align:right;">
                <table class="header-meta">
                    <tr>
                        <td>Tanggal</td>
                        <td>{{ \Carbon\Carbon::parse($payroll->payday)->translatedFormat('d F Y') }}</td>
                    </tr>
                    <tr>
                        <td>No. Slip Gaji</td>
                        <td>{{ $payroll->id }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <div class="divider"></div>

    {{-- INFO PEGAWAI --}}
    <table class="info-table">
        <tr>
            <td>
                <div class="info-label">Nama Pegawai</div>
                <div class="info-value">{{ $payroll->employee->name }}</div>
            </td>
            <td>
                <div class="info-label">Jabatan</div>
                <div class="info-value">{{ $payroll->position }}</div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="info-label">Alamat</div>
                <div class="info-value">{{ $payroll->employee->address }}</div>
            </td>
            <td>
                <div class="info-label">Periode</div>
                <div class="info-value">
                    {{ DateTime::createFromFormat('!m', $payroll->monthly_period)->format('F') }}
                    {{ $payroll->year_period }}
                </div>
            </td>
        </tr>
    </table>

    {{-- SECTION HEADER --}}
    <table class="section-header-table">
        <tr>
            <td>Absensi</td>
            <td>Pendapatan</td>
            <td>Potongan</td>
        </tr>
    </table>

    {{-- SECTION BODY --}}
    <table class="columns-table">
        <tr>
            {{-- Absensi --}}
            <td>
                <table class="item-table">
                    <tr><td>Hadir</td><td>{{ $attendances->where('hadir', true)->count() }} hari</td></tr>
                    <tr><td>Sakit</td><td>{{ $attendances->where('sakit', true)->count() }} hari</td></tr>
                    <tr><td>Izin</td><td>{{ $attendances->where('izin', true)->count() }} hari</td></tr>
                    <tr><td>Alfa</td><td>{{ $attendances->where('alpa', true)->count() }} hari</td></tr>
                </table>
            </td>

            {{-- Pendapatan --}}
            <td>
                <table class="item-table">
                    <tr>
                        <td>Gaji Pokok</td>
                        <td>Rp{{ number_format($payroll->salary, 0, ',', '.') }}</td>
                    </tr>
                    @foreach ($payroll->payrollItems->where('type', '!=', 'deduction') as $item)
                        <tr>
                            <td>{{ $item->name }}</td>
                            <td>+ Rp{{ number_format($item->amount, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </table>
            </td>

            {{-- Potongan --}}
            <td>
                @if ($payroll->payrollItems->where('type', 'deduction')->isEmpty())
                    <div class="empty-note">Tidak ada potongan</div>
                @else
                    <table class="item-table">
                        @foreach ($payroll->payrollItems->where('type', 'deduction') as $item)
                            <tr>
                                <td>{{ $item->name }}</td>
                                <td>- Rp{{ number_format($item->amount, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </table>
                @endif
            </td>
        </tr>
    </table>

    {{-- TOTAL --}}
    <div class="total-wrapper">
        <table class="total-table">
            <tr>
                <td>Total Gaji Diterima</td>
                <td>Rp{{ number_format($payroll->total, 0, ',', '.') }}</td>
            </tr>
        </table>
    </div>

    {{-- FOOTER --}}
    <table class="footer-table">
        <tr>
            <td>
                <div>Dicetak pada {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</div>
                <div>Dokumen ini digenerate secara otomatis.</div>
            </td>
            <td>
                <div>Menyetujui,</div>
                <div class="sign-space">HRD / Pimpinan</div>
            </td>
        </tr>
    </table>

</div>
</body>
</html>
