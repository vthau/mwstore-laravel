<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function all_permission()
    {
        $permissions = Permission::where([["key_code", "<>", "ADMIN"], ["key_code", "<>", "ROLE"]])->get();
        return response()->json(["status" => "SUCCESS", "data" => $permissions]);
    }
}
