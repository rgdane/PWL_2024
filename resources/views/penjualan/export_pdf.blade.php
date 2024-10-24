<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <style>
            body {
                font-family: "Times New Roman", Times, serif;
                margin: 6px 20px 5px 20px;
                line-height: 15px;
            }
            table {
                width: 100%;
                border-collapse: collapse;
            }
            td, th {
                padding: 4px 3px;
            }
            th {
                text-align: left;
            }
            .d-block {
                display: block;
            }
            .text-right {
                text-align: right;
            }
            .text-center {
                text-align: center;
            }
            .p-1 {
                padding: 5px 1px 5px 1px;
            }
            .font-10 {
                font-size: 10pt;
            }
            .font-11 {
                font-size: 11pt;
            }
            .font-12 {
                font-size: 12pt;
            }
            .font-13 {
                font-size: 13pt;
            }
            .border-bottom-header {
                border-bottom: 1px solid;
            }
            .border-all, .border-all th, .border-all td {
                border: 1px solid;
            }
            .logo-image {
                max-width: 100px;
                max-height: 100px;
                width: auto;
                height: auto;
                object-fit: contain;
            }
        </style>
    </head>
    <body>
        <table class="border-bottom-header">
            <tr>
                <td width="15%" class="text-center"><img src="{{ public_path('polinema.png') }}" class="logo-image"></td>
                <td width="85%">
                    <span class="text-center d-block font-11 font-bold mb-1">KEMENTERIAN PENDIDIKAN, KEBUDAYAAN, RISET, DAN TEKNOLOGI</span>
                    <span class="text-center d-block font-13 font-bold mb-1">POLITEKNIK NEGERI MALANG</span>
                    <span class="text-center d-block font-10">JL, Soekarno-Hatta No.9 Malang 65141</span>
                    <span class="text-center d-block font-10">Telepon (0341) 404424 Pes. 101-105 0341-404420, Fax. (0341) 404420</span>
                    <span class="text-center d-block font-10">Laman: www.polinema.ac.id</span>
                </td>
            </tr>
        </table>
        <h3 class="text-center">LAPORAN DATA TRANSAKSI PENJUALAN</h3>

        @if($penjualan->isEmpty())
            <div class="alert alert-danger">
                <h5><i class="icon fas fa-ban"></i> Kesalahan!!!</h5>
                Data yang Anda cari tidak ditemukan.
            </div>
        @else
            <h3>Penjualan</h3>
            <table class="border-all">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th>Nama Kasir</th>
                        <th>Nama Pembeli</th>
                        <th>Kode Transaksi</th>
                        <th>Tanggal Transaksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($penjualan as $p)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $p->user->nama }}</td>
                        <td>{{ $p->pembeli }}</td>
                        <td>{{ $p->penjualan_kode }}</td>
                        <td>{{ $p->penjualan_tanggal }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <br>
            <h3>Penjualan Detail</h3>
            <table class="border-all">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Kode Transaksi</th>
                        <th class="text-center">Nama Barang</th>
                        <th class="text-center">Harga Barang</th>
                        <th class="text-center">Jumlah Barang</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($penjualan_detail as $item)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="text-center">{{ $item->penjualan->penjualan_kode }}</td>
                        <td class="text-center">{{ $item->barang->barang_nama }}</td>
                        <td class="text-center">Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                        <td class="text-center">{{ $item->jumlah }}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <th class="text-center" colspan="3">Total Harga</th>
                        <td class="text-center" colspan="2">Rp {{ number_format($total_harga, 0, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>
        @endif
    </body>
</html>
