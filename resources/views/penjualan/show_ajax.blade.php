@empty($penjualan)
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="exampleModalLabel">
                    <i class="fas fa-exclamation-triangle mr-2"></i>Kesalahan
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center py-5">
                <div class="alert alert-danger d-inline-block">
                    <h5><i class="icon fas fa-ban mr-2"></i>Data tidak ditemukan!</h5>
                    Data transaksi yang anda cari tidak tersedia dalam sistem
                </div>
                <div class="mt-4">
                    <a href="{{ url('/penjualan') }}" class="btn btn-warning">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
@else
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content border-0 shadow">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    <i class="fas fa-file-invoice mr-2"></i>Detail Transaksi Penjualan
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info bg-light border-info">
                    <h5 class="text-info"><i class="icon fas fa-info-circle mr-2"></i>Informasi Transaksi</h5>
                    <p class="mb-0">Detail transaksi penjualan</p>
                </div>
                
                <!-- Customer Info Card -->
                <div class="card mb-4 shadow-sm">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">Informasi Transaksi</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-sm table-borderless">
                                    <tr>
                                        <th class="text-muted w-50">Nama Kasir</th>
                                        <td>: {{ $penjualan->user->nama }}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-muted">Nama Pembeli</th>
                                        <td>: {{ $penjualan->pembeli }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-sm table-borderless">
                                    <tr>
                                        <th class="text-muted w-50">Kode Transaksi</th>
                                        <td>: {{ $penjualan->penjualan_kode }}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-muted">Tanggal</th>
                                        <td>: {{ $penjualan->penjualan_tanggal }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Items Table Card -->
                <div class="card shadow-sm">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">Detail Transaksi</h6>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="text-center">No.</th>
                                        <th>Nama Barang</th>
                                        <th class="text-right">Harga</th>
                                        <th class="text-center">Jumlah</th>
                                        <th class="text-right">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($penjualan_detail as $index => $item)
                                    <tr>
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td>{{ $item->barang->barang_nama }}</td>
                                        <td class="text-right">Rp {{ number_format($item->harga, 0, ',','.') }}</td>
                                        <td class="text-center">{{ $item->jumlah }}</td>
                                        <td class="text-right">Rp {{ number_format($item->jumlah * $item->harga, 0, ',','.') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="bg-light font-weight-bold">
                                    <tr>
                                        <td colspan="4" class="text-right">Total :</td>
                                        <td class="text-right">Rp {{ number_format($total_harga, 0,',','.') }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-warning" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="btn-print-invoice">Cetak Invoice</button>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $("#btn-print-invoice").on("click", function() {
                var invoiceContent = `
                    <html>
                    <head>
                        <title>Invoice Penjualan - {{ $penjualan->penjualan_kode }}</title>
                        <style>
                            body {
                                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                                margin: 0;
                                padding: 30px;
                                background-color: #f8f9fa;
                                color: #333;
                            }
                            .invoice-container {
                                max-width: 800px;
                                margin: auto;
                                background: white;
                                padding: 30px;
                                border-radius: 10px;
                                box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
                            }
                            .header {
                                text-align: center;
                                border-bottom: 2px solid #e9ecef;
                                padding-bottom: 20px;
                                margin-bottom: 30px;
                            }
                            .header h1 {
                                color: #2c3e50;
                                margin: 0;
                                font-size: 28px;
                            }
                            .invoice-info {
                                margin: 20px 0;
                                display: grid;
                                grid-template-columns: repeat(2, 1fr);
                                gap: 20px;
                            }
                            .invoice-info p {
                                margin: 5px 0;
                                color: #555;
                            }
                            .invoice-info strong {
                                color: #2c3e50;
                            }
                            table {
                                width: 100%;
                                border-collapse: collapse;
                                margin: 30px 0;
                            }
                            th, td {
                                border: 1px solid #dee2e6;
                                padding: 12px;
                                text-align: left;
                            }
                            th {
                                background-color: #f8f9fa;
                                color: #2c3e50;
                                font-weight: 600;
                            }
                            tr:nth-child(even) {
                                background-color: #f8f9fa;
                            }
                            .total {
                                font-weight: bold;
                                background-color: #e9ecef;
                            }
                            .footer {
                                text-align: center;
                                margin-top: 30px;
                                padding-top: 20px;
                                border-top: 2px solid #e9ecef;
                                color: #6c757d;
                            }
                            .footer p {
                                margin: 5px 0;
                            }
                            @media print {
                                body {
                                    background: white;
                                    padding: 0;
                                }
                                .invoice-container {
                                    box-shadow: none;
                                }
                            }
                        </style>
                    </head>
                    <body>
                        <div class="invoice-container">
                            <div class="header">
                                <h1>Bukti Transaksi</h1>
                                <p style="color: #6c757d; margin-top: 5px;">{{ $penjualan->penjualan_kode }}</p>
                            </div>
                            
                            <div class="invoice-info">
                                <div>
                                    <p><strong>Nama Kasir:</strong> {{ $penjualan->user->nama }}</p>
                                    <p><strong>Nama Pembeli:</strong> {{ $penjualan->pembeli }}</p>
                                </div>
                                <div>
                                    <p><strong>Tanggal Transaksi:</strong> {{ $penjualan->penjualan_tanggal }}</p>
                                    <p><strong>Status:</strong> <span style="color: #28a745;">Lunas</span></p>
                                </div>
                            </div>
                            <table>
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama Barang</th>
                                        <th style="text-align: right;">Harga</th>
                                        <th style="text-align: center;">Jumlah</th>
                                        <th style="text-align: right;">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($penjualan_detail as $index => $item)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $item->barang->barang_nama }}</td>
                                            <td style="text-align: right;">Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                                            <td style="text-align: center;">{{ $item->jumlah }}</td>
                                            <td style="text-align: right;">Rp {{ number_format($item->jumlah * $item->harga, 0, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr class="total">
                                        <td colspan="4" style="text-align: right;"><strong>Total Pembayaran</strong></td>
                                        <td style="text-align: right;"><strong>Rp {{ number_format($total_harga, 0, ',', '.') }}</strong></td>
                                    </tr>
                                </tfoot>
                            </table>
                            <div class="footer">
                                <p>Layanan Konsumen</p>
                                <p>SMS WA 089747832 TELP 14022</p>
                                
                            </div>
                        </div>
                    </body>
                    </html>
                `;
                var newWindow = window.open('', '_blank');
                newWindow.document.write(invoiceContent);
                newWindow.document.close();
                newWindow.print();
                newWindow.close();
            });
        });
    </script>
@endempty