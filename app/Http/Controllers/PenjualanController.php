<?php
namespace App\Http\Controllers;
use App\Models\BarangModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\UserModel;
use App\Models\PenjualanDetailModel;
use App\Models\PenjualanModel;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Barryvdh\DomPDF\Facade\Pdf;
use Barryvdh\DomPDF\PDF as DomPDFPDF;
use DateTime;

class PenjualanController extends Controller
{
    public function index(){
        $breadcrumb = (object)[
            'title' => 'Daftar Penjualan',
            'list' => ['Home', 'Penjualan']
        ];
        $page = (object)[
            'title' => 'Daftar penjualan yang tersedia dalam sistem'
        ];
        $user = UserModel::all(); 
        $activeMenu = 'penjualan'; // set menu yang sedang aktif
        return view('penjualan.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu, 'user' => $user]);
    }
    public function list(Request $request){
        $penjualans = PenjualanModel::select('penjualan_id', 'user_id', 'pembeli', 'penjualan_kode', 'penjualan_tanggal')->with( 'user');
        //Filter data user berdasarkan supplier_id
        if($request->user_id){
            $penjualans->where('user_id', $request->user_id);
        }
        return DataTables::of($penjualans)
            // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addIndexColumn()
            ->addColumn('aksi', function ($penjualan){ //menambahkan kolom aksi
                $btn = '<button onclick="modalAction(\''.url('/penjualan/'. $penjualan->penjualan_id . '/show_ajax').'\')" class="btn btn-info btn-sm col-9">Detail</button> ';
                // $btn .= '<button onclick="modalAction(\''.url('/penjualan/' . $penjualan->penjualan_id . '/edit_ajax').'\')" class="btn btn-warning btn-sm">Edit</button> ';
                // $btn .= '<button onclick="modalAction(\''.url('/penjualan/' . $penjualan->penjualan_id . '/delete_ajax').'\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
            ->make(true);
    }
    public function destroy(string $id){
        $check = PenjualanModel::find($id);
        if(!$check){ // untuk mengecek apakah data penjualan dengan id yang dimaksud ada atau tidak
            return redirect('/penjualan')->with('error', 'Data penjualan tidak ditemukan');
        }
        try{
            PenjualanModel::destroy($id); //Hapus data penjualan
            return redirect('/penjualan')->with('success', 'Data penjualan berhasil dihapus');
        } catch(\Illuminate\Database\QueryException $e){
            //jika terjadi error ketika menghapus data, redirect kembali ke halaman dengan membawa pesan error
            return redirect('/penjualan')->with('error', 'Data penjualan gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
    public function create_ajax() {
        $user = UserModel::all();
        $barang = BarangModel::all();
        return view('penjualan.create_ajax', ['user' => $user, 'barang' => $barang]);
    }
    public function store_ajax(Request $request) {
        // cek apakah request berupa ajax
        if($request->ajax() || $request->wantsJson()) {
            $rules = [
                'user_id' => 'required|integer',
                'pembeli' => 'required|min:3|max:255',
                'penjualan_kode' => 'required|min:3|max:255|unique:t_penjualan,penjualan_kode',
                'penjualan_tanggal' => 'required'
            ];
            //use Illuminate\Support\Facades\Validator;
            $validator = Validator::make($request->all(), $rules);
            if($validator->fails()){
                return response()->json([
                    'status' => false, // response status, false: error/gagal, true: berhasil
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(), // pesan error validasi
                ]);
            }
            
            try{
                DB::beginTransaction();
                $penjualan = PenjualanModel::create([
                    'user_id' => $request->user_id,
                    'pembeli' => $request->pembeli,
                    'penjualan_kode' => $request->penjualan_kode,
                    'penjualan_tanggal' => $request->penjualan_tanggal
                ]);
                $barangIds = $request->barang_id;
                $jumlahs = $request->jumlah;
                foreach ($barangIds as $key => $barangId) {
                    
                    if(empty($barangId)) continue;
                    $harga_barang = BarangModel::find($barangId);
                    PenjualanDetailModel::create([
                        'penjualan_id' => $penjualan->penjualan_id,
                        'barang_id' => $barangId,
                        'harga' => $harga_barang->harga_jual,
                        'jumlah' => $jumlahs[$key]
                    ]);
                }
                DB::commit();
                return response()->json([
                    'status' => true,
                    'message' => 'Data penjualan berhasil disimpan'
                ]);
            } catch(\Exception $e){
                DB::rollBack();
                
                return response()->json([
                    'status' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ]);
            }
            
        }
        redirect('/');
    }
    public function show_ajax(string $id){
        $penjualan = PenjualanModel::find($id);
        // $penjualan_detail = PenjualanDetailModel::where('penjualan_id', $id)->select('penjualan_id', 'barang_id', 'harga', 'jumlah')->get();
        $penjualan_detail = PenjualanDetailModel::where('penjualan_id', $id)->select('penjualan_id', 'barang_id', 'harga', 'jumlah')->get();
        $total_harga = PenjualanDetailModel::where('penjualan_id', $id)->select(DB::raw('SUM(harga * jumlah) as total_harga'))->first()->total_harga;
        return view('penjualan.show_ajax', ['penjualan' => $penjualan, 'penjualan_detail' => $penjualan_detail, 'total_harga' => $total_harga]);
    }
    public function edit_ajax(string $id){
        $penjualan = PenjualanModel::find($id);
        $user = UserModel::select('user_id', 'nama')->get();
        return view('penjualan.edit_ajax',['penjualan' => $penjualan, 'user' => $user]);
    }
    public function update_ajax(Request $request, String $id){
        //cek apakah request dari ajax
        if($request->ajax() || $request->wantsJson()){
            $rules =[
                'penjualan_id' => 'required|integer',
                'user_id' => 'required|integer',
                'pembeli' => 'required|min:3|max:255',
                'penjualan_kode' => 'required|min:3|max:255|unique:t_penjualan,penjualan_kode,'.$id.',penjualan_id',
                'penjualan_tanggal' => 'required'
            ];
            // use Illuminate\Support\Facades\Validator;
            $validator = Validator::make($request->all(), $rules);
            if($validator->fails()){
                return response()->json([
                    'status' => false, //respon json, true: berhasil, false: gagal
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors() // menunjukkan field mana yang error
                ]);
            }
            $check = PenjualanModel::find($id);
            if($check){
                $check->update($request->all());
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diupdate'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
        return redirect('/');
    }
    public function confirm_ajax(string $id){
        $penjualan = PenjualanModel::find($id);
        return view('penjualan.confirm_ajax', ['penjualan' => $penjualan]);
    }
    public function delete_ajax(Request $request, $id){
        // cek apakah request dari ajax
        if($request->ajax() || $request->wantsJson()){
            $penjualan = PenjualanModel::find($id);
            if($penjualan){
                $penjualan->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil dihapus'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
        return redirect('/');
    }
    public function import() {
        return view('penjualan.import');
    }
    public function import_ajax(Request $request){
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                // validasi file harus xls atau xlsx, max 1MB
                'file_penjualan' => ['required', 'mimes:xlsx', 'max:1024']
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }
            $file = $request->file('file_penjualan'); // ambil file dari request
            $reader = IOFactory::createReader('Xlsx'); // load reader file excel
            $reader->setReadDataOnly(true); // hanya membaca data
            $spreadsheet = $reader->load($file->getRealPath()); // load file excel
            $sheet = $spreadsheet->getActiveSheet(); // ambil sheet yang aktif
            $data = $sheet->toArray(null, false, true, true); // ambil data excel
            $insert = [];
            if (count($data) > 1) { // jika data lebih dari 1 baris
                foreach ($data as $baris => $value) {
                    if ($baris > 1) { // baris ke 1 adalah header, maka lewati
                        $insert[] = [
                            'penjualan_id' => $value['A'],
                            'user_id' => $value['B'],
                            'pembeli' => $value['C'],
                            'penjualan_kode' => $value['D'],
                            'penjualan_tanggal' => $value['E'],
                            'created_at' => now(),
                        ];
                    }
                }
                if (count($insert) > 0) {
                    // insert data ke database, jika data sudah ada, maka diabaikan
                    PenjualanModel::insertOrIgnore($insert);
                }
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diimport'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Tidak ada data yang diimport'
                ]);
            }
        }
        return redirect('/penjualan');
    }
    public function export_excel(){
        // Ambil data penjualan
        $penjualan = PenjualanModel::select('user_id', 'pembeli', 'penjualan_kode', 'penjualan_tanggal')
            ->orderBy('user_id')
            ->with('user')
            ->get();
        
        // Ambil data detail transaksi, termasuk informasi barang
        $detailTransaksi = PenjualanDetailModel::select('penjualan_id', 'barang_id', 'jumlah', 'harga')
            ->orderBy('penjualan_id')
            ->with('penjualan', 'barang')
            ->get();
    
        // Load library Excel
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    
        // SHEET 1: Data Transaksi Penjualan
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Data Transaksi Penjualan'); // Set title sheet
    
        // Header untuk sheet 1
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Nama Kasir');
        $sheet->setCellValue('C1', 'Nama Pembeli');
        $sheet->setCellValue('D1', 'Kode Transaksi');
        $sheet->setCellValue('E1', 'Tanggal Transaksi');
        $sheet->getStyle('A1:E1')->getFont()->setBold(true); // Bold header
    
        // Isi data transaksi penjualan
        $no = 1;
        $baris = 2;
        foreach($penjualan as $key => $value){
            $sheet->setCellValue('A'.$baris, $no);
            $sheet->setCellValue('B'.$baris, $value->user->nama);
            $sheet->setCellValue('C'.$baris, $value->pembeli);
            $sheet->setCellValue('D'.$baris, $value->penjualan_kode);
            $sheet->setCellValue('E'.$baris, $value->penjualan_tanggal);
            $baris++;
            $no++;
        }
    
        // Set auto size untuk kolom di sheet 1
        foreach(range('A','E') as $columnID){
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }
    
        // SHEET 2: Detail Transaksi
        $detailSheet = $spreadsheet->createSheet();
        $detailSheet->setTitle('Detail Transaksi'); // Set title sheet detail transaksi
    
        // Header untuk sheet 2
        $detailSheet->setCellValue('A1', 'No');
        $detailSheet->setCellValue('B1', 'Kode Transaksi');
        $detailSheet->setCellValue('C1', 'Nama Barang');
        $detailSheet->setCellValue('D1', 'Harga Barang');
        $detailSheet->setCellValue('E1', 'Jumlah');
        $detailSheet->getStyle('A1:E1')->getFont()->setBold(true); // Bold header
    
        // Isi data detail transaksi
        $no = 1;
        $baris = 2;
        foreach($detailTransaksi as $key => $detail){
            $detailSheet->setCellValue('A'.$baris, $no);
            $detailSheet->setCellValue('B'.$baris, $detail->penjualan->penjualan_kode); // Kode transaksi dari penjualan
            $detailSheet->setCellValue('C'.$baris, $detail->barang->barang_nama); // Nama barang
            $detailSheet->setCellValue('D'.$baris, $detail->harga); // Harga barang
            $detailSheet->setCellValue('E'.$baris, $detail->jumlah); // Jumlah barang
            $baris++;
            $no++;
        }
    
        // Set auto size untuk kolom di sheet 2
        foreach(range('A','E') as $columnID){
            $detailSheet->getColumnDimension($columnID)->setAutoSize(true);
        }
    
        // Simpan file Excel
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data Transaksi Penjualan '.date('Y-m-d H:i:s').'.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit;
    }
    
    public function export_pdf()
    {
        // Ambil data transaksi penjualan dan detailnya
        $penjualan = PenjualanModel::with('user')
            ->orderBy('user_id')
            ->get();
        
        $penjualan_detail = PenjualanDetailModel::with('barang')
            ->whereIn('penjualan_id', $penjualan->pluck('penjualan_id')) // Filter by penjualan_id
            ->get();

        // Menghitung total harga
        $total_harga = $penjualan_detail->sum(function ($detail) {
            return $detail->harga * $detail->jumlah;
        });

        // Load view yang sama seperti yang di-generate HTML tadi
        $pdf = PDF::loadView('penjualan.export_pdf', compact('penjualan', 'penjualan_detail', 'total_harga'));

        // Optional: Set orientasi dan ukuran kertas
        $pdf->setPaper('A4', 'portrait'); // Potrait atau landscape sesuai kebutuhan

        // Return file PDF untuk di-download
        return $pdf->stream('Data_Transaksi_Penjualan_'.date('Y-m-d_H-i-s').'.pdf');
    }
}