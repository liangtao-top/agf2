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

class JavaTerminalResponse extends Struct
{

    private JavaApiResponse $api;

    private JavaAdminResponse $admin;

    /**
     * @return \com\agf2\struct\JavaApiResponse
     */
    public function getApi(): JavaApiResponse
    {
        return $this->api;
    }

    /**
     * setApi
     * @param \com\agf2\struct\JavaApiResponse $api
     * @return $this
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2021/8/20 14:05
     */
    public function setApi(JavaApiResponse $api): self
    {
        $this->api = $api;
        return $this;
    }

    /**
     * @return \com\agf2\struct\JavaAdminResponse
     */
    public function getAdmin(): JavaAdminResponse
    {
        return $this->admin;
    }

    /**
     * setAdmin
     * @param \com\agf2\struct\JavaAdminResponse $admin
     * @return $this
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date   2021/8/20 14:04
     */
    public function setAdmin(JavaAdminResponse $admin): self
    {
        $this->admin = $admin;
        return $this;
    }

}
