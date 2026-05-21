<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Health check
Route::get('/health', fn() => response()->json(['status' => 'ok', 'timestamp' => now()]));

// Le rotte API principali sono definite in web.php sotto /api/v1
// (per semplicità su cPanel senza separazione di middleware API)
