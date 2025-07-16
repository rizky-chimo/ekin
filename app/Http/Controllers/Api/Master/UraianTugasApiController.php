<?php

namespace App\Http\Controllers\Api\Master;

use App\Http\Controllers\Controller;
use App\Models\UraianTugas;
use Illuminate\Http\Request;

/**
 * @OA\Tag(name="Uraian Tugas")
 */
class UraianTugasApiController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/uraian-tugas",
     *     tags={"Uraian Tugas"},
     *     summary="List semua uraian tugas",
     *     @OA\Response(response=200, description="Berhasil")
     * )
     */
    public function index()
    {
        return response()->json(UraianTugas::with(['indikator', 'rhkStaff', 'instansi'])->get());
    }

    /**
     * @OA\Post(
     *     path="/api/uraian-tugas",
     *     tags={"Uraian Tugas"},
     *     summary="Tambah uraian tugas",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"indikator_id", "rhk_staff_id", "instansi_id", "uraian"},
     *             @OA\Property(property="indikator_id", type="integer", example=1),
     *             @OA\Property(property="rhk_staff_id", type="integer", example=2),
     *             @OA\Property(property="instansi_id", type="integer", example=1),
     *             @OA\Property(property="uraian", type="string", example="Menginput data absensi harian")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Berhasil ditambahkan"),
     *     @OA\Response(response=422, description="Validasi gagal")
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'indikator_id' => 'required|exists:indikator,id',
            'rhk_staff_id' => 'required|exists:rhk_staff,id',
            'instansi_id' => 'required|exists:instansi,id',
            'uraian' => 'required|string|max:255',
        ]);

        $data = UraianTugas::create($request->all());
        return response()->json($data->load(['indikator', 'rhkStaff', 'instansi']), 201);
    }

    /**
     * @OA\Get(
     *     path="/api/uraian-tugas/{id}",
     *     tags={"Uraian Tugas"},
     *     summary="Ambil detail uraian tugas",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="OK"),
     *     @OA\Response(response=404, description="Tidak ditemukan")
     * )
     */
    public function show($id)
    {
        $data = UraianTugas::with(['indikator', 'rhkStaff', 'instansi'])->find($id);
        if (!$data) return response()->json(['message' => 'Not found'], 404);
        return response()->json($data);
    }

    /**
     * @OA\Put(
     *     path="/api/uraian-tugas/{id}",
     *     tags={"Uraian Tugas"},
     *     summary="Update uraian tugas",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"indikator_id", "rhk_staff_id", "instansi_id", "uraian"},
     *             @OA\Property(property="indikator_id", type="integer", example=1),
     *             @OA\Property(property="rhk_staff_id", type="integer", example=2),
     *             @OA\Property(property="instansi_id", type="integer", example=1),
     *             @OA\Property(property="uraian", type="string", example="Membuat laporan bulanan")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Berhasil diupdate"),
     *     @OA\Response(response=404, description="Tidak ditemukan")
     * )
     */
    public function update(Request $request, $id)
    {
        $data = UraianTugas::find($id);
        if (!$data) return response()->json(['message' => 'Not found'], 404);

        $request->validate([
            'indikator_id' => 'required|exists:indikator,id',
            'rhk_staff_id' => 'required|exists:rhk_staff,id',
            'instansi_id' => 'required|exists:instansi,id',
            'uraian' => 'required|string|max:255',
        ]);

        $data->update($request->all());
        return response()->json($data->load(['indikator', 'rhkStaff', 'instansi']));
    }

    /**
     * @OA\Delete(
     *     path="/api/uraian-tugas/{id}",
     *     tags={"Uraian Tugas"},
     *     summary="Hapus uraian tugas",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=204, description="Berhasil dihapus"),
     *     @OA\Response(response=404, description="Tidak ditemukan")
     * )
     */
    public function destroy($id)
    {
        $data = UraianTugas::find($id);
        if (!$data) return response()->json(['message' => 'Not found'], 404);

        $data->delete();
        return response()->json(null, 204);
    }
}
