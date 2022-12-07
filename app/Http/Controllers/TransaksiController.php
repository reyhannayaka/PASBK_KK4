<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use App\Models\Tiket;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transaksi = Transaksi::all();
        return response()->json([
            'status' => '200',
            'message' => 'data berhasil di buat',
            'data' => $transaksi
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tiket = Tiket::find($request->id);
        $harga_tiket = $tiket->harga;
        $total_harga = $request->jumlah_tiket * $harga_tiket;
        if($total_harga != 0){
            $tiket->stok = $tiket->stok - $request->jumlah_tiket;
            $tiket->save();
            $transaksis = Transaksi::create([
                'transaksi_id' => uniqid(),
                'jumlah_tiket' => $request->jumlah_tiket,
                'harga_tiket' => $harga_tiket,
                'total_harga' => $total_harga,
                'nama_konser' => $tiket->nama_konser,
                'alamat_konser' => $tiket->alamat,
                'tanggal_konser' => $tiket->tanggal_konser
            ]);
            return response()->json([
                'status' => 200,
                'message' => "data successfully created",
                'data' => $transaksis
            ], 200);
        } else {
            return response()->json([
                'status' => 406,
                'message' => "total_harga can't be 0",
                'data' => 'null'
            ], 406);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $transaksis = Transaksi::find($id);
        if($transaksis){
            return response()->json([
                'status' => 200,
                'message' => "data berhasil dibuat",
                'data' => $transaksis
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => "transaksi id $id  not found",
                'data' => 'null'
            ], 404);
        };
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if($request->id != null){
            $transaksis = Transaksi::find($id);
            $tiket = Tiket::find($request->id);
            $harga_tiket = $tiket->harga;
            $total_harga = $request->jumlah_tiket * $harga_tiket;
            if($transaksis){
                if($request->jumlah_tiket != 0){
                    $transaksis->transaksi_id = $transaksis->transaksi_id;
                    $transaksis->total_harga = $total_harga;
                    $transaksis->jumlah_tiket = $request->jumlah_tiket;
                    $transaksis->harga_tiket = $harga_tiket;
                    $transaksis->nama_konser = $tiket->nama_konser;
                    $transaksis->alamat_konser = $tiket->alamat;
                    $transaksis->tanggal_konser = $tiket->tanggal_konser;
                    $transaksis->save();
                    return response()->json([
                        'status' => 200,
                        'message' => 'data berhasil di hapus',
                        'data' => $transaksis
                    ], 200);
                } else {
                    return response()->json([
                        'status' => 418,
                        'message' => "jumlah tiket tidak boleh kurang dari 1", 
                        'data' => 'null'
                    ], 418);
                }
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => "transaksi id $id tidak di temukan", 
                    'data' => 'null'
                ], 404);
            };
        } else {
            return response()->json([
                'status' => 418,
                'message' => "tiket_id is required", 
                'data' => 'null'
            ], 418);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $transaksis = Transaksi::where('id', $id)->first();
        if($transaksis){
            $transaksis->delete();
            return response()->json([
                'status' => 200,
                'message' => "data berhasil di hapus",
                'data' => $transaksis
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => "transaksi id $id not found",
                'data' => 'null'
            ], 404);
        }
    }
}
