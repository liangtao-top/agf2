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
package com.dm.frame.application.admin.validate.##region##;

import com.dm.frame.application.common.validate.FormData;
import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.EqualsAndHashCode;
import lombok.NoArgsConstructor;
##import##

@EqualsAndHashCode(callSuper = true)
@Data // 提供类所有属性的 getting 和 setting 方法，此外还提供了equals、canEqual、hashCode、toString 方法
@NoArgsConstructor // 注解在类上；为类提供一个无参的构造方法
@AllArgsConstructor // 注解在类上；为类提供一个全参的构造方法
public class ##className##Validate extends FormData {

##fields##

}
