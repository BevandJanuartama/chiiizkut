<?php
namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast; // Tambahkan ini
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PesananBaru implements ShouldBroadcast // Tambahkan 'implements ShouldBroadcast'
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public $jumlahPesanan) {}

    public function broadcastOn(): array {
        return [new Channel('kasir-channel')];
    }
}