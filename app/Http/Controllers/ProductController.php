<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        $produk = Product::all();
        return response()->json($produk);
    }

    public function show($id) {
        $produk = Product::find($id);
        return response()->json($produk);
    }

    public function create(Request $request) {
        $this->validate($request,[
            'nama' => 'required|string',
            'harga' => 'required|integer',
            'warna' => 'required|string',
            'kondisi' => 'required|string',
            'deskripsi' => 'required|string'
        ]);

        $data = $request->all();
        $produk= Product::create($data);

        return response()->json($produk);
    }

    public function update(Request $request,$id) {
        $this->validate($request,[
            'nama' => '|string',
            'harga' => '|integer',
            'warna' => '|string',
            'kondisi' => '|string',
            'deskripsi' => '|string'
        ]);
        $produk = Product::find($id);
        if (!$produk) {
            return response()->json(['message'=>'Data Tidak ada'],404);
        }
        $data = $request->all();
        $produk->fill($data);
        $produk->save();
        return response()->json($produk);
    }

    public function destroy($id) {
        $produk = Product::find($id);
        if (!$produk) {
            return response()->json(['message'=>'Data Tidak ada'],404);
        }
        $produk->delete();
        return response()->json(['message'=>'Data Sudah Dihapus']);
        
    }
}
