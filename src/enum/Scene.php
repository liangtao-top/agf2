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
// | Version: 2.0 2021/8/20 15:39
// +----------------------------------------------------------------------
namespace com\agf2\enum;

use PhpEnum\Enum;

/**
 * 场景枚举类
 * @method static BUILD()
 * @method static SAVE()
 * @method static RELEASE()
 * @method static REMOVE()
 * @method static MENU()
 */
class Scene extends Enum
{

    const BUILD = [0, 'build'];

    const SAVE = [1, 'save'];

    const RELEASE = [2, 'release'];

    const REMOVE = [3, 'remove'];

    const MENU = [4, 'menu'];


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
