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
// | Version: 2.0 2021/8/19 17:34
// +----------------------------------------------------------------------
namespace com\agf2\struct;

use com\struct\Struct;

class Response extends Struct
{

    private PHPTerminalResponse $php;

    private JavaTerminalResponse $java;

    /**
     * @return \com\agf2\struct\PHPTerminalResponse
     */
    public function getPhp(): PHPTerminalResponse
    {
        return $this->php;
    }

    /**
     * setPhp
     * @param \com\agf2\struct\PHPTerminalResponse $php
     * @return $this
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2021/8/20 12:27
     */
    public function setPhp(PHPTerminalResponse $php): self
    {
        $this->php = $php;
        return $this;
    }

    /**
     * @return \com\agf2\struct\JavaTerminalResponse
     */
    public function getJava(): JavaTerminalResponse
    {
        return $this->java;
    }

    /**
     * setJava
     * @param \com\agf2\struct\JavaTerminalResponse $java
     * @return $this
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2021/8/20 12:27
     */
    public function setJava(JavaTerminalResponse $java): self
    {
        $this->java = $java;
        return $this;
    }

}
