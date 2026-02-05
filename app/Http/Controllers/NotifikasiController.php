<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotifikasiController extends Controller
{
    /**
     * Tandai semua notifikasi sebagai sudah dibaca
     */
    public function markAsRead()
    {
        $userId = auth()->user()->idUser;

        DB::table('notifikasi')
            ->where('idUser', $userId)
            ->where('is_read', false)
            ->update([
                'is_read' => true, 
                'updated_at' => now()
            ]);

        return response()->json(['success' => true]);
    }

    /**
     * Hapus semua notifikasi milik user yang sedang login
     */
    public function deleteAll()
    {
        $userId = auth()->user()->idUser;

        DB::table('notifikasi')
            ->where('idUser', $userId)
            ->delete();

        return response()->json(['success' => true]);
    }
}
