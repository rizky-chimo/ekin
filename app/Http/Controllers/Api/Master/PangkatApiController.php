<?php

namespace App\Http\Controllers\Api\Master;

use App\Http\Controllers\Controller;
use App\Models\Pangkat;
use Illuminate\Http\Request;

/**
 * @OA\Tag(name="Pangkat")
 */
class PangkatApiController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/pangkat",
     *     tags={"Pangkat"},
     *     summary="List semua pangkat",
     *     @OA\Response(response=200, description="Berhasil")
     * )
     */
    public function index()
    {
        return response()->json(Pangkat::all());
    }

    /**
     * @OA\Post(
     *     path="/api/pangkat",
     *     tags={"Pangkat"},
     *     summary="Tambah pangkat",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nama", "golongan"},
     *             @OA\Property(property="nama", type="string", example="Penata Muda"),
     *             @OA\Property(property="golongan", type="string", example="III/a")
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
            'golongan' => 'required|string|max:10',
        ]);

        $data = Pangkat::create($request->only('nama', 'golongan'));
        return response()->json($data, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/pangkat/{id}",
     *     tags={"Pangkat"},
     *     summary="Ambil detail pangkat",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="OK"),
     *     @OA\Response(response=404, description="Tidak ditemukan")
     * )
     */
    public function show($id)
    {
        $data = Pangkat::find($id);
        if (!$data) return response()->json(['message' => 'Not found'], 404);
        return response()->json($data);
    }

    /**
     * @OA\Put(
     *     path="/api/pangkat/{id}",
     *     tags={"Pangkat"},
     *     summary="Update pangkat",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nama", "golongan"},
     *             @OA\Property(property="nama", type="string", example="Pembina"),
     *             @OA\Property(property="golongan", type="string", example="IV/a")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Update berhasil"),
     *     @OA\Response(response=404, description="Data tidak ditemukan")
     * )
     */
    public function update(Request $request, $id)
    {
        $data = Pangkat::find($id);
        if (!$data) return response()->json(['message' => 'Not found'], 404);

        $request->validate([
            'nama' => 'required|string|max:255',
            'golongan' => 'required|string|max:10',
        ]);

        $data->update($request->only('nama', 'golongan'));
        return response()->json($data);
    }

    /**
     * @OA\Delete(
     *     path="/api/pangkat/{id}",
     *     tags={"Pangkat"},
     *     summary="Hapus pangkat",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=204, description="Berhasil dihapus"),
     *     @OA\Response(response=404, description="Tidak ditemukan")
     * )
     */
    public function destroy($id)
    {
        $data = Pangkat::find($id);
        if (!$data) return response()->json(['message' => 'Not found'], 404);

        $data->delete();
        return response()->json(null, 204);
    }
}
