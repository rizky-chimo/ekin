<?php

namespace App\Http\Controllers\Api\Master;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

/**
 * @OA\Tag(name="User")
 */
class UserApiController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/users",
     *     tags={"User"},
     *     summary="List semua user",
     *     @OA\Response(response=200, description="Berhasil")
     * )
     */
    public function index()
    {
        return response()->json(User::with(['jabatan', 'pangkat', 'instansi', 'atasan'])->get());
    }

    /**
     * @OA\Post(
     *     path="/api/users",
     *     tags={"User"},
     *     summary="Tambah user",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nama", "username", "password"},
     *             @OA\Property(property="nama", type="string", example="Ahmad Syah"),
     *             @OA\Property(property="username", type="string", example="ahmad"),
     *             @OA\Property(property="email", type="string", example="ahmad@mail.com"),
     *             @OA\Property(property="password", type="string", example="secret123"),
     *             @OA\Property(property="jabatan_id", type="integer", example=1),
     *             @OA\Property(property="pangkat_id", type="integer", example=1),
     *             @OA\Property(property="id_atasan", type="integer", example=2),
     *             @OA\Property(property="instansi_id", type="integer", example=1),
     *             @OA\Property(property="nip", type="string", example="197901012003121002"),
     *             @OA\Property(property="nik", type="string", example="3674020101900001"),
     *             @OA\Property(property="jenis_pegawai", type="string", example="pns"),
     *             @OA\Property(property="no_wa", type="string", example="081234567890")
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
            'username' => 'required|string|unique:users',
            'password' => 'required|string|min:6',
            'email' => 'nullable|email|unique:users',
            'nip' => 'nullable|string',
            'nik' => 'nullable|string',
            'jenis_pegawai' => 'nullable|in:pns,non_pns',
            'no_wa' => 'nullable|string',
            'jabatan_id' => 'nullable|exists:jabatan,id',
            'pangkat_id' => 'nullable|exists:pangkat,id',
            'id_atasan' => 'nullable|exists:users,id',
            'instansi_id' => 'nullable|exists:instansi,id',
        ]);

        $data = User::create([
            ...$request->except('password'),
            'password' => bcrypt($request->password),
        ]);

        return response()->json($data->load(['jabatan', 'pangkat', 'instansi', 'atasan']), 201);
    }

    /**
     * @OA\Get(
     *     path="/api/users/{id}",
     *     tags={"User"},
     *     summary="Ambil detail user",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="OK"),
     *     @OA\Response(response=404, description="Tidak ditemukan")
     * )
     */
    public function show($id)
    {
        $data = User::with(['jabatan', 'pangkat', 'instansi', 'atasan'])->find($id);
        if (!$data) return response()->json(['message' => 'Not found'], 404);
        return response()->json($data);
    }

    /**
     * @OA\Put(
     *     path="/api/users/{id}",
     *     tags={"User"},
     *     summary="Update user",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="nama", type="string", example="Ahmad Syah"),
     *             @OA\Property(property="username", type="string", example="ahmad"),
     *             @OA\Property(property="email", type="string", example="ahmad@mail.com"),
     *             @OA\Property(property="password", type="string", example="newpassword123"),
     *             @OA\Property(property="jabatan_id", type="integer", example=1),
     *             @OA\Property(property="pangkat_id", type="integer", example=1),
     *             @OA\Property(property="id_atasan", type="integer", example=2),
     *             @OA\Property(property="instansi_id", type="integer", example=1),
     *             @OA\Property(property="nip", type="string", example="197901012003121002"),
     *             @OA\Property(property="nik", type="string", example="3674020101900001"),
     *             @OA\Property(property="jenis_pegawai", type="string", example="non_pns"),
     *             @OA\Property(property="no_wa", type="string", example="081234567891")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Berhasil diupdate"),
     *     @OA\Response(response=404, description="Data tidak ditemukan")
     * )
     */
    public function update(Request $request, $id)
    {
        $data = User::find($id);
        if (!$data) return response()->json(['message' => 'Not found'], 404);

        $request->validate([
            'nama' => 'sometimes|required|string|max:255',
            'username' => 'sometimes|required|string|unique:users,username,' . $id,
            'email' => 'nullable|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:6',
            'nip' => 'nullable|string',
            'nik' => 'nullable|string',
            'jenis_pegawai' => 'nullable|in:pns,non_pns',
            'no_wa' => 'nullable|string',
            'jabatan_id' => 'nullable|exists:jabatan,id',
            'pangkat_id' => 'nullable|exists:pangkat,id',
            'id_atasan' => 'nullable|exists:users,id',
            'instansi_id' => 'nullable|exists:instansi,id',
        ]);

        $updateData = $request->except('password');
        if ($request->filled('password')) {
            $updateData['password'] = bcrypt($request->password);
        }

        $data->update($updateData);
        return response()->json($data->load(['jabatan', 'pangkat', 'instansi', 'atasan']));
    }

    /**
     * @OA\Delete(
     *     path="/api/users/{id}",
     *     tags={"User"},
     *     summary="Hapus user",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=204, description="Berhasil dihapus"),
     *     @OA\Response(response=404, description="Tidak ditemukan")
     * )
     */
    public function destroy($id)
    {
        $data = User::find($id);
        if (!$data) return response()->json(['message' => 'Not found'], 404);

        $data->delete();
        return response()->json(null, 204);
    }
}
