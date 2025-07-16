<?php

namespace App\Http\Controllers\Api\Master;

use App\Http\Controllers\Controller;
use App\Models\Jabatan;
use Illuminate\Http\Request;

/**
 * @OA\Tag(name="Jabatan")
 */
class JabatanApiController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/jabatan",
     *     tags={"Jabatan"},
     *     summary="List semua jabatan",
     *     @OA\Response(response=200, description="Berhasil")
     * )
     */
    public function index()
    {
        return response()->json(Jabatan::all());
    }

    /**
     * @OA\Post(
     *     path="/api/jabatan",
     *     tags={"Jabatan"},
     *     summary="Tambah jabatan",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nama", "kode"},
     *             @OA\Property(property="nama", type="string", example="Kepala Dinas"),
     *             @OA\Property(property="kode", type="string", example="KD01")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Berhasil ditambahkan"),
     *     @OA\Response(response=422, description="Validasi gagal")
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kode' => 'required|string|max:50',
        ]);

        $data = Jabatan::create($request->only('nama', 'kode'));
        return response()->json($data, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/jabatan/{id}",
     *     tags={"Jabatan"},
     *     summary="Ambil detail jabatan",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="OK"),
     *     @OA\Response(response=404, description="Tidak ditemukan")
     * )
     */
    public function show($id)
    {
        $data = Jabatan::find($id);
        if (!$data) return response()->json(['message' => 'Not found'], 404);
        return response()->json($data);
    }

    /**
     * @OA\Put(
     *     path="/api/jabatan/{id}",
     *     tags={"Jabatan"},
     *     summary="Update jabatan",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nama", "kode"},
     *             @OA\Property(property="nama", type="string", example="Sekretaris"),
     *             @OA\Property(property="kode", type="string", example="SK01")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Update berhasil"),
     *     @OA\Response(response=404, description="Data tidak ditemukan")
     * )
     */
    public function update(Request $request, $id)
    {
        $data = Jabatan::find($id);
        if (!$data) return response()->json(['message' => 'Not found'], 404);

        $request->validate([
            'nama' => 'required|string|max:255',
            'kode' => 'required|string|max:50',
        ]);

        $data->update($request->only('nama', 'kode'));
        return response()->json($data);
    }

    /**
     * @OA\Delete(
     *     path="/api/jabatan/{id}",
     *     tags={"Jabatan"},
     *     summary="Hapus jabatan",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=204, description="Berhasil dihapus"),
     *     @OA\Response(response=404, description="Tidak ditemukan")
     * )
     */
    public function destroy($id)
    {
        $data = Jabatan::find($id);
        if (!$data) return response()->json(['message' => 'Not found'], 404);

        $data->delete();
        return response()->json(null, 204);
    }
}
