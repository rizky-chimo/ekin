<?php

namespace App\Http\Controllers\Api\Master;

use App\Http\Controllers\Controller;
use App\Models\Instansi;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

/**
 * @OA\Tag(name="Instansi")
 *
 * @OA\Schema(
 *     schema="InstansiRequest",
 *     required={"nama"},
 *     @OA\Property(property="nama", type="string", example="Dinas Pendidikan")
 * )
 */
class InstansiApiController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/instansi",
     *     tags={"Instansi"},
     *     summary="List semua instansi",
     *     security={{"sanctum":{}}},
     *     @OA\Response(response=200, description="Berhasil")
     * )
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => 'Daftar instansi',
            'data' => Instansi::all(),
        ]);
    }

   /**
 * @OA\Post(
 *     path="/api/instansi",
 *     tags={"Instansi"},
 *     summary="Tambah instansi",
 *     security={{"sanctum":{}}},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/x-www-form-urlencoded",
 *             @OA\Schema(
 *                 required={"nama"},
 *                 @OA\Property(property="nama", type="string", example="Dinas Pendidikan")
 *             )
 *         )
 *     ),
 *     @OA\Response(response=201, description="Berhasil ditambahkan"),
 *     @OA\Response(
 *         response=422,
 *         description="Validasi gagal",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Validasi gagal"),
 *             @OA\Property(property="errors", type="object",
 *                 @OA\Property(
 *                     property="nama",
 *                     type="array",
 *                     @OA\Items(type="string", example="Nama Instansi Wajib diisi")
 *                 )
 *             )
 *         )
 *     )
 * )
 */

public function store(Request $request): JsonResponse
{
    try {
        $validated = $request->validate([
            'nama' => 'required|string|max:255|unique:instansi,nama',
        ], [
            'nama.required' => 'Nama Instansi Wajib diisi',
            'nama.unique' => 'Nama Instansi sudah ada, harap pilih nama lain',
        ]);
    } catch (ValidationException $e) {
        return response()->json([
            'success' => false,
            'message' => 'Validasi gagal',
            'errors' => $e->errors(),
        ], 422);
    }

    $instansi = Instansi::create($validated);

    return response()->json([
        'success' => true,
        'message' => 'Instansi berhasil ditambahkan',
        'data' => $instansi,
    ], 201);
}


    /**
     * @OA\Get(
     *     path="/api/instansi/{id}",
     *     tags={"Instansi"},
     *     summary="Detail instansi",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="OK"),
     *     @OA\Response(response=404, description="Tidak ditemukan")
     * )
     */
    public function show($id): JsonResponse
    {
        $data = Instansi::find($id);

        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Instansi tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }

    /**
     * @OA\Put(
     *     path="/api/instansi/{id}",
     *     tags={"Instansi"},
     *     summary="Update instansi",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/InstansiRequest")
     *     ),
     *     @OA\Response(response=200, description="Update berhasil"),
     *     @OA\Response(
     *         response=422,
     *         description="Validasi gagal",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The given data was invalid."),
     *             @OA\Property(property="errors", type="object",
     *                 @OA\Property(
     *                     property="nama",
     *                     type="array",
     *                     @OA\Items(type="string", example="The nama field is required.")
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function update(Request $request, $id): JsonResponse
    {
        $data = Instansi::find($id);

        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Instansi tidak ditemukan',
            ], 404);
        }

        $validated = $request->validate([
            'nama' => 'required|string|max:255|unique:instansi,nama,' . $id,
        ]);

        $data->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Instansi berhasil diperbarui',
            'data' => $data,
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/instansi/{id}",
     *     tags={"Instansi"},
     *     summary="Hapus instansi",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=204, description="Berhasil dihapus"),
     *     @OA\Response(response=404, description="Tidak ditemukan")
     * )
     */
    public function destroy($id): JsonResponse
    {
        $data = Instansi::find($id);

        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Instansi tidak ditemukan',
            ], 404);
        }

        $data->delete();

        return response()->json(null, 204);
    }
}
