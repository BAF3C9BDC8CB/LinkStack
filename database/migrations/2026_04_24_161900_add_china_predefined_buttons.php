<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    private array $buttons = [
        ["name" => "wechat", "alt" => "微信", "exclude" => false, "group" => "default", "mb" => false],
        ["name" => "qq", "alt" => "QQ", "exclude" => false, "group" => "default", "mb" => false],
        ["name" => "qqmusic", "alt" => "QQ音乐", "exclude" => false, "group" => "default", "mb" => false],
        ["name" => "neteasecloudmusic", "alt" => "网易云音乐", "exclude" => false, "group" => "default", "mb" => false],
        ["name" => "dingtalk", "alt" => "钉钉", "exclude" => false, "group" => "default", "mb" => false],
        ["name" => "feishu", "alt" => "飞书", "exclude" => false, "group" => "default", "mb" => false],
        ["name" => "baidunetdisk", "alt" => "百度网盘", "exclude" => false, "group" => "default", "mb" => false],
        ["name" => "aliyundrive", "alt" => "阿里云盘", "exclude" => false, "group" => "default", "mb" => false],
        ["name" => "pan115", "alt" => "115网盘", "exclude" => false, "group" => "default", "mb" => false],
        ["name" => "pan123", "alt" => "123云盘", "exclude" => false, "group" => "default", "mb" => false],
        ["name" => "xiaohongshu", "alt" => "小红书", "exclude" => false, "group" => "default", "mb" => false],
        ["name" => "bilibili", "alt" => "哔哩哔哩", "exclude" => false, "group" => "default", "mb" => false],
        ["name" => "douyin", "alt" => "抖音", "exclude" => false, "group" => "default", "mb" => false],
        ["name" => "kuaishou", "alt" => "快手", "exclude" => false, "group" => "default", "mb" => false],
    ];

    public function up(): void
    {
        foreach ($this->buttons as $button) {
            DB::table('buttons')->updateOrInsert(
                ['name' => $button['name']],
                $button
            );
        }
    }

    public function down(): void
    {
        DB::table('buttons')->whereIn('name', array_column($this->buttons, 'name'))->delete();
    }
};
