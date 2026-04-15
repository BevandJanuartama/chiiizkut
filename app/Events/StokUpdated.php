<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast; // Tambahkan ini
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StokUpdated implements ShouldBroadcast // Tambahkan 'implements ShouldBroadcast'
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public $produkId, public $stokBaru) {}

    public function broadcastOn(): array {
        return [new Channel('inventory')];
    }

    public function broadcastWith(): array
    {
        return [
            'produk_id' => $this->produkId, // Memastikan di JS dibaca sebagai produk_id
            'stok_baru' => $this->stokBaru,
        ];
    }
}