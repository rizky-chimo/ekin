<?php

namespace App\Http\Controllers\Api\Master;

use App\Http\Controllers\Controller;
use App\Models\RhkStaff;
use Illuminate\Http\Request;

/**
 * @OA\Tag(name="RHK Staff")
 */
class RhkStaffApiController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/rhk-staff",
     *     tags={"RHK Staff"},
     *     summary="List semua RHK staff",
     *     @OA\Response(response=200, description="Berhasil")
     * )
     */
    public function index()
    {
        return response()->json(RhkStaff::with(['jabatan', 'indikator', 'instansi'])->get());
    }

    /**
     * @OA\Post(
     *     path="/api/rhk-staff",
     *     tags={"RHK Staff"},
     *     summary="Tambah RHK staff",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"jabatan_id", "indikator_id", "instansi_id", "uraian", "nilai", "tahun"},
     *             @OA\Property(property="jabatan_id", type="integer", example=1),
     *             @OA\Property(property="indikator_id", type="integer", example=2),
     *             @OA\Property(property="instansi_id", type="integer", example=1),
     *             @OA\Property(property="uraian", type="string", example="Menyusun laporan kegiatan harian"),
     *             @OA\Property(property="nilai", type="number", format="float", example=85.5),
     *             @OA\Property(property="tahun", type="integer", example=2025)
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
            'indikator_id' => 'required|exists:indikator,id',
            'instansi_id' => 'required|exists:instansi,id',
            'uraian' => 'required|string|max:255',
            'nilai' => 'required|numeric|min:0|max:100',
            'tahun' => 'required|digits:4|integer|min:2000|max:' . date('Y')
        ]);

        $data = RhkStaff::create($request->all());
        return response()->json($data->load(['jabatan', 'indikator', 'instansi']), 201);
    }

    /**
     * @OA\Get(
     *     path="/api/rhk-staff/{id}",
     *     tags={"RHK Staff"},
     *     summary="Ambil detail RHK staff",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="OK"),
     *     @OA\Response(response=404, description="Tidak ditemukan")
     * )
     */
    public function show($id)
    {
        $data = RhkStaff::with(['jabatan', 'indikator', 'instansi'])->find($id);
        if (!$data) return response()->json(['message' => 'Not found'], 404);
        return response()->json($data);
    }

    /**
     * @OA\Put(
     *     path="/api/rhk-staff/{id}",
     *     tags={"RHK Staff"},
     *     summary="Update RHK staff",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"jabatan_id", "indikator_id", "instansi_id", "uraian", "nilai", "tahun"},
     *             @OA\Property(property="jabatan_id", type="integer", example=1),
     *             @OA\Property(property="indikator_id", type="integer", example=2),
     *             @OA\Property(property="instansi_id", type="integer", example=1),
     *             @OA\Property(property="uraian", type="string", example="Rekap data bulanan"),
     *             @OA\Property(property="nilai", type="number", example=90.25),
     *             @OA\Property(property="tahun", type="integer", example=2025)
     *         )
     *     ),
     *     @OA\Response(response=200, description="Berhasil diupdate"),
     *     @OA\Response(response=404, description="Data tidak ditemukan")
     * )
     */
    public function update(Request $request, $id)
    {
        $data = RhkStaff::find($id);
        if (!$data) return response()->json(['message' => 'Not found'], 404);

        $request->validate([
            'jabatan_id' => 'required|exists:jabatan,id',
            'indikator_id' => 'required|exists:indikator,id',
            'instansi_id' => 'required|exists:instansi,id',
            'uraian' => 'required|string|max:255',
            'nilai' => 'required|numeric|min:0|max:100',
            'tahun' => 'required|digits:4|integer|min:2000|max:' . date('Y')
        ]);

        $data->update($request->all());
        return response()->json($data->load(['jabatan', 'indikator', 'instansi']));
    }

    /**
     * @OA\Delete(
     *     path="/api/rhk-staff/{id}",
     *     tags={"RHK Staff"},
     *     summary="Hapus RHK staff",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=204, description="Berhasil dihapus"),
     *     @OA\Response(response=404, description="Data tidak ditemukan")
     * )
     */
    public function destroy($id)
    {
        $data = RhkStaff::find($id);
        if (!$data) return response()->json(['message' => 'Not found'], 404);

        $data->delete();
        return response()->json(null, 204);
    }
}
