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
use com\agf2\library\gen\java\Admin;
use com\agf2\library\gen\java\Api;
use com\agf2\struct\JavaTerminalResponse;
use top\liangtao\single\Singleton;

class Java extends GenAbs
{

    use Singleton;

    public function build(): JavaTerminalResponse
    {
        $response = new JavaTerminalResponse();
        return match ($this->getTerminal()) {
            Terminal::API() => $response->setApi(Api::build()),
            Terminal::ADMIN() => $response->setAdmin(Admin::build()),
            default => $response->setApi(Api::build())->setAdmin(Admin::build())
        };
    }

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
