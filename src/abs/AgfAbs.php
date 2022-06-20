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
// | Version: 2.0 2021/8/19 14:32
// +----------------------------------------------------------------------
namespace com\agf2\abs;

use com\agf2\enum\Language;
use com\agf2\enum\Terminal;
use com\agf2\library\Config;
use com\agf2\struct\Response;

abstract class AgfAbs
{

    private array $data;

    private Language $language;

    private Terminal $terminal;

    abstract function build(): Response;

    abstract function write(): void;

    /**
     * __construct
     * @param array|null                   $data
     * @param \com\agf2\enum\Language|null $language
     * @param \com\agf2\enum\Terminal|null $terminal
     */
    public function __construct(array $data = null, Language $language = null, Terminal $terminal = null)
    {
        $this->data     = is_null($data) ? [] : $data;
        $this->language = is_null($language) ? Language::ALL() : $language;
        $this->terminal = is_null($terminal) ? Terminal::ALL() : $terminal;
        Config::instance()->setData($this->data);
    }

    /**
     * getData
     * @return array
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2021/8/19 17:15
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * setData
     * @param array $data
     * @return $this
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2021/8/19 17:14
     */
    public function setData(array &$data): static
    {
        $this->data = &$data;
        Config::instance()->setData($this->data);
        return $this;
    }

    /**
     * getLanguage
     * @return \com\agf2\enum\Language
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2021/8/19 17:04
     */
    public function getLanguage(): Language
    {
        return $this->language;
    }

    /**
     * setLanguage
     * @param Language $language
     * @return $this
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2021/8/19 16:44
     */
    public function setLanguage(Language $language): static
    {
        $this->language = $language;
        return $this;
    }

    /**
     * getTerminal
     * @return \com\agf2\enum\Terminal
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2021/8/19 17:04
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
     * @date   2021/8/19 17:04
     */
    public function setTerminal(Terminal $terminal): static
    {
        $this->terminal = $terminal;
        return $this;
    }

}
