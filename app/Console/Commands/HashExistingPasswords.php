<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class HashExistingPasswords extends Command
{
    protected $signature = 'hash:existing-passwords';
    protected $description = 'Hash semua password plaintext yang ada di tabel users';

    public function handle()
    {
        $users = DB::table('users')->get();
        $hashed = 0;
        $skipped = 0;

        foreach ($users as $user) {
            // Cek apakah password sudah di-hash (bcrypt selalu diawali $2y$ atau $2a$)
            if (str_starts_with($user->password, '$2y$') || str_starts_with($user->password, '$2a$')) {
                $skipped++;
                $this->line("  ⏭ {$user->name} — sudah di-hash, skip.");
                continue;
            }

            DB::table('users')
                ->where('id', $user->id)
                ->update([
                    'password' => Hash::make($user->password),
                ]);

            $hashed++;
            $this->info("  ✅ {$user->name} — password berhasil di-hash.");
        }

        $this->newLine();
        $this->info("Selesai! {$hashed} password di-hash, {$skipped} sudah hash (skip).");

        return Command::SUCCESS;
    }
}
