<?php
declare(strict_types=1);
// +----------------------------------------------------------------------
// | CodeEngine
// +----------------------------------------------------------------------
// | Copyright 艾邦
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: TaoGe <liangtao.gz@foxmail.com>
// +----------------------------------------------------------------------
// | Version: 2.0 2021/8/18 12:26
// +----------------------------------------------------------------------
namespace com\agf2\traits;

trait Singleton
{

    private static ?self $instance = null;

    // 私有化构造方法
    private function __construct()
    {
    }

    // 私有化克隆方法
    private function __clone()
    {
    }

    // 重写__sleep方法，将返回置空，防止序列化反序列化获得新的对象
    public function __sleep()
    {
        return [];
    }

    public static function instance(): static
    {
        if (is_null(self::$instance)) {
            self::$instance = new static();//这里不能new self(),self和static区别
        }
        return self::$instance;
    }

}
