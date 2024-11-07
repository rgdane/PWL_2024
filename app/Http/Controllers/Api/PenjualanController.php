<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BarangModel;
use App\Models\PenjualanDetailModel;
use App\Models\PenjualanModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PenjualanController extends Controller
{
    public function index()
    {
        return PenjualanModel::all();
    }

    public function store(Request $request){
        $rules = [
            'user_id' => 'required|integer',
            'pembeli' => 'required|min:3|max:255',
            'penjualan_kode' => 'required|min:3|max:255|unique:t_penjualan,penjualan_kode',
            'penjualan_tanggal' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
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
        $penjualan = PenjualanModel::create([
            'user_id' => $request->user_id,
            'pembeli' => $request->pembeli,
            'penjualan_kode' => $request->penjualan_kode,
            'penjualan_tanggal' => $request->penjualan_tanggal,
            'image' => $request->image->hashName(),
        ]);
        return response()->json($penjualan, 201);
    }

    public function show(PenjualanModel $penjualan)
    {
        return PenjualanModel::find($penjualan);
    }
}
