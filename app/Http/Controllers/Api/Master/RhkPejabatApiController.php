<?php

namespace App\Http\Controllers\Api\Master;

use App\Http\Controllers\Controller;
use App\Models\RhkPejabat;
use Illuminate\Http\Request;

/**
 * @OA\Tag(name="RHK Pejabat")
 */
class RhkPejabatApiController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/rhk-pejabat",
     *     tags={"RHK Pejabat"},
     *     summary="List semua RHK pejabat",
     *     @OA\Response(response=200, description="Berhasil")
     * )
     */
    public function index()
    {
        return response()->json(RhkPejabat::with(['jabatan', 'instansi'])->get());
    }

    /**
     * @OA\Post(
     *     path="/api/rhk-pejabat",
     *     tags={"RHK Pejabat"},
     *     summary="Tambah RHK pejabat",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"jabatan_id", "instansi_id", "uraian"},
     *             @OA\Property(property="jabatan_id", type="integer", example=1),
     *             @OA\Property(property="instansi_id", type="integer", example=1),
     *             @OA\Property(property="uraian", type="string", example="Mengawasi pelaksanaan kegiatan instansi")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Berhasil ditambahkan"),
     *     @OA\Response(response=422, description="Validasi gagal")
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'jabatan_id' => 'required|exists:jabatan,id',
            'instansi_id' => 'required|exists:instansi,id',
            'uraian' => 'required|string|max:255',
        ]);

        $data = RhkPejabat::create($request->only('jabatan_id', 'instansi_id', 'uraian'));
        return response()->json($data->load(['jabatan', 'instansi']), 201);
    }

    /**
     * @OA\Get(
     *     path="/api/rhk-pejabat/{id}",
     *     tags={"RHK Pejabat"},
     *     summary="Ambil detail RHK pejabat",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="OK"),
     *     @OA\Response(response=404, description="Tidak ditemukan")
     * )
     */
    public function show($id)
    {
        $data = RhkPejabat::with(['jabatan', 'instansi'])->find($id);
        if (!$data) return response()->json(['message' => 'Not found'], 404);
        return response()->json($data);
    }

    /**
     * @OA\Put(
     *     path="/api/rhk-pejabat/{id}",
     *     tags={"RHK Pejabat"},
     *     summary="Update RHK pejabat",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"jabatan_id", "instansi_id", "uraian"},
     *             @OA\Property(property="jabatan_id", type="integer", example=1),
     *             @OA\Property(property="instansi_id", type="integer", example=1),
     *             @OA\Property(property="uraian", type="string", example="Mengarahkan kebijakan sektor pendidikan")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Update berhasil"),
     *     @OA\Response(response=404, description="Data tidak ditemukan")
     * )
     */
    public function update(Request $request, $id)
    {
        $data = RhkPejabat::find($id);
        if (!$data) return response()->json(['message' => 'Not found'], 404);

        $request->validate([
            'jabatan_id' => 'required|exists:jabatan,id',
            'instansi_id' => 'required|exists:instansi,id',
            'uraian' => 'required|string|max:255',
        ]);

        $data->update($request->only('jabatan_id', 'instansi_id', 'uraian'));
        return response()->json($data->load(['jabatan', 'instansi']));
    }

    /**
     * @OA\Delete(
     *     path="/api/rhk-pejabat/{id}",
     *     tags={"RHK Pejabat"},
     *     summary="Hapus RHK pejabat",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=204, description="Berhasil dihapus"),
     *     @OA\Response(response=404, description="Tidak ditemukan")
     * )
     */
    public function destroy($id)
    {
        $data = RhkPejabat::find($id);
        if (!$data) return response()->json(['message' => 'Not found'], 404);

        $data->delete();
        return response()->json(null, 204);
    }
}
