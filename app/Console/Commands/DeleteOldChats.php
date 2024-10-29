<?php

namespace App\Console\Commands;

use App\Models\Chat;
use Illuminate\Console\Command;
use Carbon\Carbon;

class DeleteOldChats extends Command
{
    // Định nghĩa tên của command
    protected $signature = 'chats:delete-old';

    // Mô tả cho command
    protected $description = 'Xóa các bản ghi chat AI cũ hơn 7 ngày';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $sevenDaysAgo = Carbon::now()->subDays(7);

        // Xóa các chat cũ hơn 7 ngày
        Chat::where('created_at', '<', $sevenDaysAgo)->delete();

        // Hiển thị thông báo hoàn tất
        $this->info('Đã xóa các chat cũ hơn 7 ngày');
    }
}