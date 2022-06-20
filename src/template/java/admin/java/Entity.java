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
package com.dm.frame.database.migrations;
##import##
import com.dm.frame.application.common.entity.ListenerEntity;
import org.hibernate.annotations.DynamicInsert;
import org.hibernate.annotations.DynamicUpdate;
import org.hibernate.annotations.GenericGenerator;
import lombok.*;

import javax.persistence.*;

@Entity
@Table(name = "dm_##tableName##", indexes = {@Index(name = "status", columnList = "status")})
@org.hibernate.annotations.Table(appliesTo = "`dm_##tableName##`", comment = "##functionName##表")
@DynamicInsert
@DynamicUpdate
@Data
@ToString(doNotUseGetters = true)
@EqualsAndHashCode(callSuper = true)
@NoArgsConstructor
@AllArgsConstructor
public class ##className## extends ListenerEntity {

    @Id
    @GenericGenerator(name = "uuid", strategy = "org.hibernate.id.UUIDGenerator")
    @GeneratedValue(generator = "uuid")
    @Column(columnDefinition = "char(36) DEFAULT '' COMMENT 'ID'", nullable = false)
    private String id;

##fields##

    @Column(columnDefinition = "smallint(5) unsigned DEFAULT '100' COMMENT '排序'", nullable = false)
    private Integer sort;

    @Column(columnDefinition = "tinyint(1) unsigned DEFAULT '1' COMMENT '状态 0:禁用 1:正常'", nullable = false)
    private Byte status;

    @Column(columnDefinition = "int(10) unsigned DEFAULT '0' COMMENT '创建时间'", nullable = false, updatable = false)
    private Long createTime;

    @Column(columnDefinition = "int(10) unsigned DEFAULT '0' COMMENT '更新时间'", nullable = false, insertable = false)
    private Long updateTime;
##acquirer##
##modifier##
}
