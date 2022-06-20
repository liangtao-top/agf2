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
// | Version: 2.0 2021/8/20 9:19
// +----------------------------------------------------------------------
namespace com\agf2\abs;

use com\agf2\enum\Terminal;

abstract class GenAbs
{

    private Terminal $terminal;

    /**
     * getTerminal
     * @return \com\agf2\enum\Terminal
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2021/8/20 12:19
     */
    public function getTerminal(): Terminal
    {
        return $this->terminal;
    }

    /**
     * setTerminal
     * @param \com\agf2\enum\Terminal $terminal
     * @return $this
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2021/8/20 12:19
     */
    public function setTerminal(Terminal $terminal): static
    {
        $this->terminal = $terminal;
        return $this;
    }

}
