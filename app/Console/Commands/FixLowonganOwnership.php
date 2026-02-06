<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class FixLowonganOwnership extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:lowongan-ownership';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Fix lowongan ownership - ensure each lowongan belongs only to one pemberi kerja';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking lowongan ownership...');

        // Cek lowongan yang mungkin punya idPemberiKerja yang salah atau NULL
        $invalidLowongan = DB::table('lowongan')
            ->whereNull('idPemberiKerja')
            ->orWhere('idPemberiKerja', 0)
            ->get();

        if ($invalidLowongan->count() > 0) {
            $this->warn("Found {$invalidLowongan->count()} lowongan dengan idPemberiKerja yang invalid:");
            foreach ($invalidLowongan as $low) {
                $this->line("  - ID: {$low->idLowongan}, Judul: {$low->judul}");
            }
        } else {
            $this->info('✓ Semua lowongan punya idPemberiKerja yang valid');
        }

        // Cek duplikat lowongan untuk pemberi kerja yang sama
        $duplicates = DB::table('lowongan')
            ->selectRaw('idPemberiKerja, judul, COUNT(*) as count')
            ->groupBy('idPemberiKerja', 'judul')
            ->having('count', '>', 1)
            ->get();

        if ($duplicates->count() > 0) {
            $this->warn("Found {$duplicates->count()} potential duplicate lowongan");
        } else {
            $this->info('✓ Tidak ada lowongan duplikat');
        }

        // Tampilkan semua lowongan dengan pemberi kerja-nya
        $this->info("\nDaftar semua lowongan:");
        $allLowongan = DB::table('lowongan')
            ->join('PemberiKerja', 'lowongan.idPemberiKerja', '=', 'PemberiKerja.idPemberiKerja')
            ->join('user', 'PemberiKerja.idUser', '=', 'user.idUser')
            ->select('lowongan.idLowongan', 'lowongan.judul', 'lowongan.status', 'user.nama', 'user.username')
            ->orderBy('lowongan.idPemberiKerja')
            ->get();

        foreach ($allLowongan as $low) {
            $status = $low->status == 'aktif' ? '✓' : '✗';
            $this->line("{$status} [{$low->idLowongan}] {$low->judul} - {$low->nama} ({$low->username})");
        }

        $this->info("\n✓ Selesai!");
    }
}
