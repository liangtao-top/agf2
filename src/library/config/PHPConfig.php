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
// | Version: 2.0 2021/8/20 9:49
// +----------------------------------------------------------------------
namespace com\agf2\library\config;

use com\agf2\abs\ConfAbs;
use com\agf2\library\config\php\AdminConfig;
use com\agf2\library\config\php\ApiConfig;
use top\liangtao\single\Singleton;

class PHPConfig extends ConfAbs
{

    use Singleton;

    private ApiConfig $api;

    private AdminConfig $admin;

    private function __construct()
    {
        $config = include(dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'agf.php');
        parent::__construct($config['php']);
    }

    /**
     * @return \com\agf2\library\config\php\ApiConfig
     */
    public function getApi(): ApiConfig
    {
        return $this->api;
    }

    /**
     * @param \com\agf2\library\config\php\ApiConfig $api
     */
    public function setApi(ApiConfig $api): void
    {
        $this->api = $api;
    }

    /**
     * @return \com\agf2\library\config\php\AdminConfig
     */
    public function getAdmin(): AdminConfig
    {
        return $this->admin;
    }

    /**
     * @param \com\agf2\library\config\php\AdminConfig $admin
     */
    public function setAdmin(AdminConfig $admin): void
    {
        $this->admin = $admin;
    }

}
