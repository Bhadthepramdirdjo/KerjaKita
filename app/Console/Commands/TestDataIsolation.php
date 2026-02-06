<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class TestDataIsolation extends Command
{
    protected $signature = 'test:data-isolation';
    protected $description = 'Test data isolation untuk setiap pemberi kerja';

    public function handle()
    {
        $this->info('🔍 Testing Data Isolation untuk KerjaKita...\n');

        // Get all pemberi kerja
        $pemberiKerjas = DB::table('pemberikerja')
            ->join('user', 'pemberikerja.idUser', '=', 'user.idUser')
            ->select('pemberikerja.idPemberiKerja', 'user.idUser', 'user.nama', 'user.username')
            ->orderBy('pemberikerja.idPemberiKerja')
            ->get();

        foreach ($pemberiKerjas as $pk) {
            $this->line("\n📋 Pemberi Kerja: {$pk->nama} (User ID={$pk->idUser}, PemberiKerja ID={$pk->idPemberiKerja})");
            
            // Get lowongan
            $lowongans = DB::table('lowongan')
                ->where('idPemberiKerja', $pk->idPemberiKerja)
                ->get();

            if ($lowongans->count() > 0) {
                $this->line("   ├─ Total Lowongan: {$lowongans->count()}");
                foreach ($lowongans as $low) {
                    $status = $low->status === 'aktif' ? '✓' : '✗';
                    $this->line("   │  └─ [{$status}] ID={$low->idLowongan}: {$low->judul}");
                }
            } else {
                $this->line("   └─ Tidak ada lowongan");
            }

            // Get lamaran
            $lamarans = DB::table('lamaran')
                ->join('lowongan', 'lamaran.idLowongan', '=', 'lowongan.idLowongan')
                ->where('lowongan.idPemberiKerja', $pk->idPemberiKerja)
                ->select('lamaran.idLamaran', 'lamaran.status_lamaran')
                ->get();

            if ($lamarans->count() > 0) {
                $this->line("   ├─ Total Lamaran: {$lamarans->count()}");
                foreach ($lamarans as $lam) {
                    $status_icon = $lam->status_lamaran === 'pending' ? '⏳' : '✓';
                    $this->line("   │  └─ [{$status_icon}] ID={$lam->idLamaran}: {$lam->status_lamaran}");
                }
            } else {
                $this->line("   └─ Tidak ada lamaran");
            }
        }

        $this->info("\n\n✅ Data isolation test selesai!");
    }
}
