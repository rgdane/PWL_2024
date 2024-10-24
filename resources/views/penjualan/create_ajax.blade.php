<form action="{{ url('/penjualan/ajax') }}" method="POST" id="form-tambah">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    <i class="fas fa-shopping-cart mr-2"></i>
                    Tambah Transaksi Penjualan
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body bg-light">
                <div class="card shadow-sm mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">
                                        <i class="fas fa-user-circle text-primary mr-1"></i>
                                        Nama Kasir
                                    </label>
                                    <select name="user_id" id="user_id" class="form-control border-primary" required>
                                        <option value="">- Pilih Kasir -</option>
                                        @foreach($user as $l)
                                            <option value="{{ $l->user_id }}">{{ $l->nama }}</option>
                                        @endforeach
                                    </select>
                                    <small id="error-user_id" class="error-text form-text text-danger"></small>
                                </div>
                                <div class="form-group">
                                    <label class="font-weight-bold">
                                        <i class="fas fa-user text-primary mr-1"></i>
                                        Nama Pembeli
                                    </label>
                                    <input value="" type="text" name="pembeli" id="pembeli" class="form-control border-primary" required>
                                    <small id="error-pembeli" class="error-text form-text text-danger"></small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">
                                        <i class="fas fa-barcode text-primary mr-1"></i>
                                        Kode Transaksi
                                    </label>
                                    <input value="" type="text" name="penjualan_kode" id="penjualan_kode" class="form-control border-primary" required>
                                    <small id="error-penjualan_kode" class="error-text form-text text-danger"></small>
                                </div>
                                <div class="form-group">
                                    <label class="font-weight-bold">
                                        <i class="fas fa-calendar text-primary mr-1"></i>
                                        Tanggal Transaksi
                                    </label>
                                    <input value="" type="datetime-local" name="penjualan_tanggal" id="penjualan_tanggal" class="form-control border-primary" required>
                                    <small id="error-penjualan_tanggal" class="error-text form-text text-danger"></small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-body bg-light">
                    <div class="card shadow-sm">
                        <div class="card-header bg-white">
                            <h6 class="mb-0 font-weight-bold text-primary">
                                Detail Transaksi
                            </h6>
                        </div>
                        <div class="card-body" id="barang-container">
                            <div class="barang-item mb-3 pb-3 border-bottom">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label class="font-weight-bold">
                                                <i class="fas fa-boxes text-primary mr-1"></i>
                                                Pilih Barang
                                            </label>
                                            <select name="barang_id[]" class="form-control border-primary barang-select" required>
                                                <option value="">- Pilih Barang -</option>
                                                @foreach($barang as $b)
                                                    <option value="{{ $b->barang_id }}">{{ $b->barang_nama }}</option>
                                                @endforeach
                                            </select>
                                            <small class="error-text form-text text-danger"></small>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group d-flex justify-content-between align-items-center">
                                            <div style="flex-grow: 1; margin-right: 10px;">
                                                <label class="font-weight-bold">
                                                    <i class="fas fa-sort-numeric-up text-primary mr-1"></i>
                                                    Jumlah
                                                </label>
                                                <input type="number" name="jumlah[]" class="form-control border-primary jumlah-input" min="1" required>
                                                <small class="error-text form-text text-danger"></small>
                                            </div>
                                            <!-- Tombol Hapus -->
                                            <button type="button" class="btn btn-danger btn-sm remove-item" style="width: 35px; height: 35px;">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </form>
    
    <script>
    $(document).ready(function() {
    // Fungsi untuk menambahkan input barang baru
    function tambahInputBarang() {
        let newItem = $('.barang-item:first').clone();
        newItem.find('select').val(''); // Reset nilai barang
        newItem.find('input[type="number"]').val(''); // Reset nilai jumlah
        $('#barang-container').append(newItem); // Tambah ke container

        // Pastikan tombol hapus berfungsi untuk item yang baru
        newItem.find('.remove-item').on('click', function() {
            if ($('.barang-item').length > 1) {
                $(this).closest('.barang-item').remove();
            }
        });

        // Nonaktifkan tombol hapus jika hanya ada satu item
        validateRemoveButtons();
    }

    // Handler untuk menghapus item
    $(document).on('click', '.remove-item', function() {
        if ($('.barang-item').length > 1) {
            $(this).closest('.barang-item').remove();
        }
        validateRemoveButtons();
    });

    // Handler untuk perubahan pada select barang
    $(document).on('change', '.barang-select', function() {
        let jumlahInput = $(this).closest('.barang-item').find('.jumlah-input');
        if ($(this).val()) {
            jumlahInput.slideDown(300); // Tampilkan input jumlah dengan animasi

            // Jika ini adalah item terakhir, tambahkan item baru
            if ($(this).closest('.barang-item').is(':last-child')) {
                tambahInputBarang();
            }
        } else {
            jumlahInput.slideUp(300); // Sembunyikan input jumlah jika tidak ada barang dipilih
        }
    });

    // Fungsi untuk validasi tombol hapus, agar nonaktif jika hanya ada 1 barang
    function validateRemoveButtons() {
        if ($('.barang-item').length === 1) {
            $('.remove-item').prop('disabled', true); // Nonaktifkan tombol hapus jika hanya satu item
        } else {
            $('.remove-item').prop('disabled', false); // Aktifkan tombol hapus jika lebih dari satu item
        }
    }

    // Initial binding for first remove button
    validateRemoveButtons();
    });

    $("#form-tambah").validate({
            rules: {
                user_id: {
                    required: true,
                    number: true
                },
                pembeli: {
                    required: true,
                    maxlength: 50
                },
                penjualan_kode: {
                    required: true,
                },
                penjualan_tanggal: {
                    required: true                }
            },
            submitHandler: function(form) {
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: $(form).serialize(),
                    success: function(response) {
                        if (response.status) {
                            $('#myModal').modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message
                            });
                            dataPenjualan.ajax.reload();
                        } else {
                            $('.error-text').text('');
                            $.each(response.msgField, function(prefix, val) {
                                $('#error-' + prefix).text(val[0]);
                            });
                            Swal.fire({
                                icon: 'error',
                                title: 'Terjadi Kesalahan',
                                text: response.message
                            });
                        }
                    }
                });
                return false;
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });
    </script>