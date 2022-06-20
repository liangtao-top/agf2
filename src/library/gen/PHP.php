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
// | Version: 2.0 2021/8/20 12:17
// +----------------------------------------------------------------------
namespace com\agf2\library\gen;

use com\agf2\abs\GenAbs;
use com\agf2\enum\Terminal;
use com\agf2\library\gen\php\Admin;
use com\agf2\library\gen\php\Api;
use com\agf2\struct\PHPTerminalResponse;
use com\agf2\traits\Singleton;

class PHP extends GenAbs
{

    use Singleton;

    public function build(): PHPTerminalResponse
    {
        $response = new PHPTerminalResponse();
        return match ($this->getTerminal()) {
            Terminal::API() => $response->setApi(Api::build()),
            Terminal::ADMIN() => $response->setAdmin(Admin::build()),
            default => $response->setApi(Api::build())->setAdmin(Admin::build())
        };
    }

    /**
     * write
     * @throws \com\agf2\exception\GenerateException
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2022/6/17 11:23
     */
    public function write(): void
    {
        match ($this->getTerminal()) {
            Terminal::API() => Api::write(),
            Terminal::ADMIN() => Admin::write(),
            default => (function () {
                Api::write();
                Admin::write();
            })()
        };
    }

    /**
     * clean
     * @throws \com\agf2\exception\GenerateException
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2022/6/17 15:54
     */
    public function clean(): void
    {
        match ($this->getTerminal()) {
            Terminal::API() => Api::clean(),
            Terminal::ADMIN() => Admin::clean(),
            default => (function () {
                Api::clean();
                Admin::clean();
            })()
        };
    }
}
