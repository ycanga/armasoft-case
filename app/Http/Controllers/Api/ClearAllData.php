<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClearAllData extends Controller
{
    public function clearAllData()
    {
        $tables = [
            'categories',
            'stores',
            'marketplaces',
            'products',
            'product_images',
            'issues',
            'product_listings',
            'notes',
        ];

        foreach ($tables as $table) {
            DB::table($table)->truncate();
        }

        return response()->json([
            'status' => 200,
            'message' => 'All data cleared successfully',
        ]);
    }
}
