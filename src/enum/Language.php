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
// | Version: 2.0 2021/8/19 16:53
// +----------------------------------------------------------------------
namespace com\agf2\enum;

use PhpEnum\Enum;

/**
 * 语言枚举类
 * @method static ALL()
 * @method static PHP()
 * @method static JAVA()
 */
class Language extends Enum
{

    const ALL = [0, 'all'];

    const PHP = [1, 'php'];

    const JAVA = [2, 'java'];

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
