<?php
declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\UserFacade;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(): View
    {
        $roles = Role::query()->with('permissions:name')->get(['id', 'name']);

        return view('admin.user-roles', [
            'roles' => $roles
        ]);
    }

    public function findUser(string $search, UserFacade $userFacade): JsonResponse
    {
        $user = $userFacade->findUserByXnameOrEmail($search);

        if (!isset($user)) {
            return response()->json('User not found', 404);
        }

        return response()->json(['user' => $user->only(['id','email']), 'roles' => $user->roles()->get(['id','name'])]);
    }

    public function getUserByIdWithRoles(int $id, UserFacade $userFacade): JsonResponse
    {
        $user = $userFacade->getUserById($id);


        return response()->json(['user' => $user->only(['id','email']), 'roles' => $user->roles()->get(['id','name'])]);
    }

    public function assignRole(int $id, Request $request, UserFacade $userFacade): JsonResponse
    {
        $userFacade->assignRole($id, (int) $request->get('role'));

        return response()->json('success');
    }

    public function revokeRole(int $id, Request $request, UserFacade $userFacade): JsonResponse
    {
        $userFacade->revokeRole($id, (int) $request->get('role'));

        return response()->json('success');
    }
}
