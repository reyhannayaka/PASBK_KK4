<?php

namespace App\Http\Controllers;

use App\Models\Tiket;
use Illuminate\Http\Request;

class TiketsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tikets = Tiket::all();
        return response()->json([
            'status' => '200',
            'message' => 'data succesfully sent',
            'data' => $tikets
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
        $tikets = Tiket::create([
            'nomor_tiket' => uniqid(),
            'nama_konser' => $request->nama_konser,
            'tanggal_konser' => $request->tanggal_konser,
            'waktu_konser' => $request->waktu_konser,
            'nama_penyanyi' => $request->nama_penyanyi,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'nomor_kursi' => $request->nomor_kursi,
            'alamat' => $request->alamat,
            'panggung' => $request->panggung,
            'ketersediaan' => $request->ketersediaan
        ]);

        return response()->json([
            'status' => 201,
            'message' => 'data successfully created',
            'data' => $tikets
        ], 201);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tikets = Tiket::find($id);
        if($tikets){
            return response()->json([
                'status' => 200,
                'message' => "data successfully sent",
                'data' => $tikets
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => "tiket id $id  not found",
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
        $tikets = Tiket::find($id);
        if($tikets){
            $tikets->nomor_tiket = uniqid();
            $tikets->nama_konser = $request->nama_konser ? $request->nama_konser : $tikets->nama_konser;
            $tikets->tanggal_konser = $request->tanggal_konser ? $request->tanggal_konser : $tikets->tanggal_konser;
            $tikets->waktu_konser = $request->waktu_konser ? $request->waktu_konser : $tikets->waktu_konser;
            $tikets->nama_penyanyi = $request->nama_penyanyi ? $request->nama_penyanyi : $tikets->nama_penyanyi;
            $tikets->harga = $request->harga ? $request->harga : $tikets->harga;
            $tikets->stok = $request->stok ? $request->stok : $tikets->stok;
            $tikets->nomor_kursi = $request->nomor_kursi ? $request->nomor_kursi : $tikets->nomor_kursi;
            $tikets->alamat = $request->alamat ? $request->alamat : $tikets->alamat;
            $tikets->panggung = $request->panggung ? $request->panggung : $tikets->panggung;
            $tikets->ketersediaan = $request->ketersediaan ? $request->ketersediaan : $tikets->ketersediaan;
            $tikets->save();
            return response()->json([
                'status' => 200,
                'message' => 'data successfully updated',
                'data' => $tikets
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => "tiket id $id  not found", 
                'data' => 'null'
            ], 404);
        };
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tikets = Tiket::where('id', $id)->first();
        if($tikets){
            $tikets->delete();
            return response()->json([
                'status' => 200,
                'message' => "data successfully deleted",
                'data' => $tikets
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => "tiket id $id not found",
                'data' => 'null'
            ], 404);
        }
    }
}
