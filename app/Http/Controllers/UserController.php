<?php

namespace App\Http\Controllers;

use App\Http\Actions\User\SearchActiveUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request, SearchActiveUsers $searchActiveUsers): JsonResponse
    {
        $q = $request->get('q');
        $perPage = $request->get('per_page');
        $users = $searchActiveUsers($q, $perPage);
        return response()->json($users);
    }


}

