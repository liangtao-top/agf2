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
// | Version: 2.0 2021/8/19 17:51
// +----------------------------------------------------------------------
namespace com\agf2\struct;

use com\struct\Struct;

class PHPTerminalResponse extends Struct
{

    private PHPApiResponse $api;

    private PHPAdminResponse $admin;

    /**
     * @return \com\agf2\struct\PHPApiResponse
     */
    public function getApi(): PHPApiResponse
    {
        return $this->api;
    }

    /**
     * setApi
     * @param \com\agf2\struct\PHPApiResponse $api
     * @return $this
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2021/8/20 14:21
     */
    public function setApi(PHPApiResponse $api): self
    {
        $this->api = $api;
        return $this;
    }

    /**
     * @return \com\agf2\struct\PHPAdminResponse
     */
    public function getAdmin(): PHPAdminResponse
    {
        return $this->admin;
    }

    /**
     * setAdmin
     * @param \com\agf2\struct\PHPAdminResponse $admin
     * @return $this
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2021/8/20 14:21
     */
    public function setAdmin(PHPAdminResponse $admin): self
    {
        $this->admin = $admin;
        return $this;
    }

}
