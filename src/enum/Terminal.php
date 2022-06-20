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
// | Version: 2.0 2021/8/19 17:01
// +----------------------------------------------------------------------
namespace com\agf2\enum;

use PhpEnum\Enum;

/**
 * 终端枚举类
 * @method static ALL()
 * @method static API()
 * @method static ADMIN()
 */
class Terminal extends Enum
{

    const ALL = [0, 'all'];

    const API = [1, 'api'];

    const ADMIN = [2, 'admin'];

    private int $id;
    private string $name;

    protected function construct($id, $name)
    {
        $this->id   = $id;
        $this->name = $name;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
