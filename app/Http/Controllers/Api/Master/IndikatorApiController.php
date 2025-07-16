<?php

namespace App\Http\Controllers\Api\Master;

use App\Http\Controllers\Controller;
use App\Models\Indikator;
use Illuminate\Http\Request;

/**
 * @OA\Tag(name="Indikator")
 */
class IndikatorApiController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/indikator",
     *     tags={"Indikator"},
     *     summary="List semua indikator",
     *     @OA\Response(response=200, description="Berhasil")
     * )
     */
    public function index()
    {
        return response()->json(Indikator::with('instansi')->get());
    }

    /**
     * @OA\Post(
     *     path="/api/indikator",
     *     tags={"Indikator"},
     *     summary="Tambah indikator",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"instansi_id", "uraian"},
     *             @OA\Property(property="instansi_id", type="integer", example=1),
     *             @OA\Property(property="uraian", type="string", example="Meningkatkan pelayanan publik")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Berhasil ditambahkan"),
     *     @OA\Response(response=422, description="Validasi gagal")
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'instansi_id' => 'required|exists:instansi,id',
            'uraian' => 'required|string|max:255',
        ]);

        $data = Indikator::create($request->only('instansi_id', 'uraian'));
        return response()->json($data->load('instansi'), 201);
    }

    /**
     * @OA\Get(
     *     path="/api/indikator/{id}",
     *     tags={"Indikator"},
     *     summary="Ambil detail indikator",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="OK"),
     *     @OA\Response(response=404, description="Tidak ditemukan")
     * )
     */
    public function show($id)
    {
        $data = Indikator::with('instansi')->find($id);
        if (!$data) return response()->json(['message' => 'Not found'], 404);
        return response()->json($data);
    }

    /**
     * @OA\Put(
     *     path="/api/indikator/{id}",
     *     tags={"Indikator"},
     *     summary="Update indikator",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"instansi_id", "uraian"},
     *             @OA\Property(property="instansi_id", type="integer", example=1),
     *             @OA\Property(property="uraian", type="string", example="Menurunkan angka kemiskinan")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Update berhasil"),
     *     @OA\Response(response=404, description="Data tidak ditemukan")
     * )
     */
    public function update(Request $request, $id)
    {
        $data = Indikator::find($id);
        if (!$data) return response()->json(['message' => 'Not found'], 404);

        $request->validate([
            'instansi_id' => 'required|exists:instansi,id',
            'uraian' => 'required|string|max:255',
        ]);

        $data->update($request->only('instansi_id', 'uraian'));
        return response()->json($data->load('instansi'));
    }

    /**
     * @OA\Delete(
     *     path="/api/indikator/{id}",
     *     tags={"Indikator"},
     *     summary="Hapus indikator",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=204, description="Berhasil dihapus"),
     *     @OA\Response(response=404, description="Tidak ditemukan")
     * )
     */
    public function destroy($id)
    {
        $data = Indikator::find($id);
        if (!$data) return response()->json(['message' => 'Not found'], 404);

        $data->delete();
        return response()->json(null, 204);
    }
}
