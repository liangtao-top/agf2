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
package com.dm.frame.application.admin.model.##region##;

import com.dm.frame.database.migrations.##className##;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.JpaSpecificationExecutor;
import org.springframework.stereotype.Repository;

import java.io.Serializable;

@Repository("application.admin.model.##region##.##className##Model")
public interface ##className##Model extends JpaRepository<##className##, String>, JpaSpecificationExecutor<##className##>, Serializable {

}
