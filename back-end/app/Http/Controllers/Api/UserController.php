<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

/**
 * @OA\Tag(
 *     name="Users",
 *     description="API endpoints para gerenciamento de usuários (admin only)"
 * )
 */
class UserController extends Controller
{
    public function __construct()
    {
        // Constructor vazio - autorização será feita nos métodos
    }

    /**
     * @OA\Get(
     *     path="/api/users",
     *     tags={"Users"},
     *     summary="Listar todos os usuários",
     *     security={{"sanctum":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de usuários",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/User")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Não autenticado"),
     *     @OA\Response(response=403, description="Acesso negado")
     * )
     */
    public function index(): JsonResponse
    {
        // Verificar se o usuário é admin
        if (!auth()->user()->is_admin) {
            abort(403, 'Acesso negado. Apenas administradores podem gerenciar usuários.');
        }

        $users = User::all();
        return response()->json(UserResource::collection($users));
    }

    /**
     * @OA\Post(
     *     path="/api/users",
     *     tags={"Users"},
     *     summary="Criar novo usuário",
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","email","password"},
     *             @OA\Property(property="name", type="string", example="Maria Santos"),
     *             @OA\Property(property="email", type="string", format="email", example="maria@exemplo.com"),
     *             @OA\Property(property="password", type="string", format="password", example="senha123"),
     *             @OA\Property(property="is_admin", type="boolean", example=false)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Usuário criado com sucesso",
     *         @OA\JsonContent(ref="#/components/schemas/User")
     *     ),
     *     @OA\Response(response=401, description="Não autenticado"),
     *     @OA\Response(response=403, description="Acesso negado"),
     *     @OA\Response(response=422, description="Erro de validação")
     * )
     */
    public function store(StoreUserRequest $request): JsonResponse
    {
        // Verificar se o usuário é admin
        if (!auth()->user()->is_admin) {
            abort(403, 'Acesso negado. Apenas administradores podem gerenciar usuários.');
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_admin' => $request->boolean('is_admin', false),
        ]);

        return response()->json(new UserResource($user), 201);
    }

    /**
     * @OA\Get(
     *     path="/api/users/{id}",
     *     tags={"Users"},
     *     summary="Obter usuário específico",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID do usuário",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Dados do usuário",
     *         @OA\JsonContent(ref="#/components/schemas/User")
     *     ),
     *     @OA\Response(response=401, description="Não autenticado"),
     *     @OA\Response(response=403, description="Acesso negado"),
     *     @OA\Response(response=404, description="Usuário não encontrado")
     * )
     */
    public function show(User $user): JsonResponse
    {
        // Verificar se o usuário é admin
        if (!auth()->user()->is_admin) {
            abort(403, 'Acesso negado. Apenas administradores podem gerenciar usuários.');
        }

        return response()->json(new UserResource($user));
    }

    /**
     * @OA\Put(
     *     path="/api/users/{id}",
     *     tags={"Users"},
     *     summary="Atualizar usuário",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID do usuário",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="Maria Santos Silva"),
     *             @OA\Property(property="email", type="string", format="email", example="maria.silva@exemplo.com"),
     *             @OA\Property(property="password", type="string", format="password", example="novasenha123"),
     *             @OA\Property(property="is_admin", type="boolean", example=false)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Usuário atualizado com sucesso",
     *         @OA\JsonContent(ref="#/components/schemas/User")
     *     ),
     *     @OA\Response(response=401, description="Não autenticado"),
     *     @OA\Response(response=403, description="Acesso negado"),
     *     @OA\Response(response=404, description="Usuário não encontrado"),
     *     @OA\Response(response=422, description="Erro de validação")
     * )
     */
    public function update(UpdateUserRequest $request, User $user): JsonResponse
    {
        // Verificar se o usuário é admin
        if (!auth()->user()->is_admin) {
            abort(403, 'Acesso negado. Apenas administradores podem gerenciar usuários.');
        }

        $data = $request->only(['name', 'email', 'is_admin']);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return response()->json(new UserResource($user));
    }

    /**
     * @OA\Delete(
     *     path="/api/users/{id}",
     *     tags={"Users"},
     *     summary="Deletar usuário",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID do usuário",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=204, description="Usuário deletado com sucesso"),
     *     @OA\Response(response=401, description="Não autenticado"),
     *     @OA\Response(response=403, description="Acesso negado"),
     *     @OA\Response(response=404, description="Usuário não encontrado")
     * )
     */
    public function destroy(User $user): JsonResponse
    {
        // Verificar se o usuário é admin
        if (!auth()->user()->is_admin) {
            abort(403, 'Acesso negado. Apenas administradores podem gerenciar usuários.');
        }

        $user->delete();
        return response()->json(null, 204);
    }
}
