// +----------------------------------------------------------------------
// | CodeEngine
// +----------------------------------------------------------------------
// | Copyright 艾邦
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: TaoGe <liangtao.gz@foxmail.com>
// +----------------------------------------------------------------------
// | Version: 1.0 ##date##
// +----------------------------------------------------------------------
package com.dm.frame.application.admin.service.##region##;

import com.dm.frame.application.common.service.BaseService;
import com.dm.frame.application.common.validate.PageInput;

public interface ##className##Service<T> extends BaseService {

    // 额外
    Object extra();

    // 列表
    boolean index(PageInput params);

    // 新增
    boolean save(T params);

    // 读取
    boolean read(T params);

    // 修改
    boolean update(T params);

    // 状态
    boolean status(T params);

    // 删除
    boolean delete(T params);

}
