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
// | Version: 2.0 2021/8/19 14:25
// +----------------------------------------------------------------------
namespace com\agf2;

use com\agf2\abs\AgfAbs;
use com\agf2\enum\Language;
use com\agf2\enum\Scene;
use com\agf2\library\gen\Database;
use com\agf2\library\gen\Java;
use com\agf2\library\gen\PHP;
use com\agf2\struct\Response;
use com\agf2\util\Validate;

/**
 * 自动生成代码框架
 */
class AGF2 extends AgfAbs
{

    /**
     * build
     * @return \com\agf2\struct\Response
     * @throws \com\agf2\exception\ValidateException
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2021/8/20 12:15
     */
    public function build(): Response
    {
        (new Validate)->setScene(Scene::BUILD())->check($this->getData());
        $response = new Response();
        match ($this->getLanguage()) {
            Language::PHP() => $response->setPhp(PHP::instance()->setTerminal($this->getTerminal())->build()),
            Language::JAVA() => $response->setJava(Java::instance()->setTerminal($this->getTerminal())->build()),
            default => $response->setPhp(PHP::instance()->setTerminal($this->getTerminal())->build())
                                ->setJava(Java::instance()->setTerminal($this->getTerminal())->build())
        };
        return $response;
    }

    /**
     * write
     * @throws \com\agf2\exception\ValidateException
     * @throws \com\agf2\exception\GenerateException
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2022/6/16 15:06
     */
    public function write(): void
    {
        (new Validate)->setScene(Scene::RELEASE())->check($this->getData());
        match ($this->getLanguage()) {
            Language::PHP() => PHP::instance()->setTerminal($this->getTerminal())->write(),
            Language::JAVA() => Java::instance()->setTerminal($this->getTerminal())->write(),
            default => (function () {
                PHP::instance()->setTerminal($this->getTerminal())->write();
                Java::instance()->setTerminal($this->getTerminal())->write();
            })()
        };
        Database::instance()->init();
    }

    /**
     * clean
     * @throws \com\agf2\exception\GenerateException
     * @throws \com\agf2\exception\ValidateException
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2022/6/17 15:03
     */
    public function clean(): void
    {
        (new Validate)->setScene(Scene::REMOVE())->check($this->getData());
        match ($this->getLanguage()) {
            Language::PHP() => PHP::instance()->setTerminal($this->getTerminal())->clean(),
            Language::JAVA() => Java::instance()->setTerminal($this->getTerminal())->clean(),
            default => (function () {
                PHP::instance()->setTerminal($this->getTerminal())->clean();
                Java::instance()->setTerminal($this->getTerminal())->clean();
            })()
        };
        Database::instance()->clean();
    }

    /**
     * menu
     * @return int
     * @throws \com\agf2\exception\GenerateException
     * @throws \com\agf2\exception\ValidateException
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2022/6/17 14:27
     */
    public function menu(): int
    {
        (new Validate)->setScene(Scene::MENU())->check($this->getData());
        return Database::instance()->menu();
    }
}
