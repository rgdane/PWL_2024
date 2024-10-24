@extends('layouts.template')
@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                <button onclick="modalAction('{{ url('/stok/import') }}')" class="btn btn-info"><i class="fa fa-file-excel"></i> Import Stok</button>
                <a href="{{ url('/stok/export_excel') }}" class="btn btn-primary"><i class="fa fa-file-excel"></i> Export Stok</a>
                <a href="{{ url('/stok/export_pdf') }}" class="btn btn-warning"><i class="fa fa-file-pdf"></i> Export Stok</a>
                <button onclick="modalAction('{{ url('/stok/create_ajax') }}')" class="btn btn-success">Tambah Data</button>
            </div>
        </div>
        <div class="card-body">
            @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            
            <table class="table table-border table-striped table-hover table-sm" id="table_stok">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Supplier</th>
                        <th>Nama Barang</th>
                        <th>Karyawan</th>
                        <th>Tanggal</th>
                        <th>Jumlah</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" data-width="75%" aria-hidden="true"></div>
@endsection
@push('css')
@endpush
@push('js')
    <script>
        function modalAction(url = ''){
            $('#myModal').load(url,function(){
                $('#myModal').modal('show');
            });
        }
        var dataStok;
        $(document).ready(function(){
            dataStok = $('#table_stok').DataTable({
                //serverSide: true, jika ingin menggunakan server side processing
                serverSide: true,
                ajax:{
                    "url": "{{ url('stok/list') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": function (d){
                        d.supplier_id = $('#supplier_id').val() || null;
                        d.barang_id = $('#barang_id').val() || null;
                        d.user_id = $('#user_id').val() || null;
                    }
                },
                columns:[
                    {
                        //nomor urut dari laravel datatable addIndexColumn()
                        data: "DT_RowIndex",
                        className: "text-center",
                        orderable: false,
                        searchable: false
                    },{
                        data: "supplier.supplier_nama",
                        className: "",
                        orderable: false,
                        searchable: true
                    },{
                        data: "barang.barang_nama",
                        className: "",
                        orderable:false,
                        searchable: true
                    },{
                        // mengambil data level dari hasil ORM berelasi
                        data: "user.nama",
                        className: "",
                        orderable: false,
                        searchable: true
                    },{
                        data: "stok_tanggal",
                        className: "",
                        orderable:true,
                        searchable: true
                    },{
                        data: "stok_jumlah",
                        className: "",
                        orderable:true,
                        searchable: true
                    },{
                        data: "aksi",
                        className: "",
                        orderable:false,
                        searchable: false
                    }
                ]
            });
        });
    </script>
@endpush