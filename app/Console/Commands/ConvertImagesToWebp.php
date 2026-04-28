<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ConvertImagesToWebp extends Command
{
    protected $signature   = 'images:convert-webp';
    protected $description = 'Convert semua gambar produk ke WebP';

    public function handle()
    {
        $manager = new ImageManager(new Driver());
        $produks = DB::table('produks')->whereNotNull('gambar')->get();

        $this->info("Ditemukan {$produks->count()} produk...");

        foreach ($produks as $p) {
            $oldPath = storage_path('app/public/' . $p->gambar);

            if (str_ends_with($p->gambar, '.webp') || !file_exists($oldPath)) {
                $this->line("Skip: {$p->gambar}");
                continue;
            }

            $newFilename = pathinfo($p->gambar, PATHINFO_DIRNAME)
                         . '/'
                         . pathinfo($p->gambar, PATHINFO_FILENAME)
                         . '.webp';
            $newPath = storage_path('app/public/' . $newFilename);

            $manager->decode($oldPath)
                ->cover(600, 400)
                 ->encode(new \Intervention\Image\Encoders\WebpEncoder(quality: 75))
                ->save($newPath);

            DB::table('produks')->where('id', $p->id)->update(['gambar' => $newFilename]);
            unlink($oldPath);

            $this->info("✓ {$p->nama_produk}");
        }

        $this->info('Selesai!');
    }
}