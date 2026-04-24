<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    private array $buttons = [
        ["name" => "qiyeweixin", "alt" => "企业微信", "exclude" => false, "group" => "default", "mb" => false],
        ["name" => "weibo", "alt" => "微博", "exclude" => false, "group" => "default", "mb" => false],
        ["name" => "zhihu", "alt" => "知乎", "exclude" => false, "group" => "default", "mb" => false],
        ["name" => "douban", "alt" => "豆瓣", "exclude" => false, "group" => "default", "mb" => false],
        ["name" => "taobao", "alt" => "淘宝", "exclude" => false, "group" => "default", "mb" => false],
        ["name" => "xianyu", "alt" => "闲鱼", "exclude" => false, "group" => "default", "mb" => false],
        ["name" => "meituan", "alt" => "美团", "exclude" => false, "group" => "default", "mb" => false],
        ["name" => "dazhongdianping", "alt" => "大众点评", "exclude" => false, "group" => "default", "mb" => false],
        ["name" => "jingdong", "alt" => "京东", "exclude" => false, "group" => "default", "mb" => false],
        ["name" => "pinduoduo", "alt" => "拼多多", "exclude" => false, "group" => "default", "mb" => false],
        ["name" => "xunlei", "alt" => "迅雷云盘", "exclude" => false, "group" => "default", "mb" => false],
        ["name" => "quark", "alt" => "夸克网盘", "exclude" => false, "group" => "default", "mb" => false],
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
