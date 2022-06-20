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
package com.dm.frame.application.admin.service.##region##.impl;
##import##
import com.alibaba.fastjson.JSONObject;
import com.dm.frame.application.admin.service.##region##.##className##Service;
import com.dm.frame.application.common.validate.PageInput;
import com.dm.frame.application.common.service.BaseServiceImpl;
import com.dm.frame.application.admin.model.##region##.##className##Model;
import com.dm.frame.database.migrations.##className##;
import com.dm.frame.application.common.util.Helper;
import com.dm.frame.application.common.util.DateUtil;
import com.dm.frame.application.admin.validate.##region##.##className##Validate;
import org.apache.commons.lang3.StringUtils;
import org.springframework.beans.BeanUtils;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.domain.PageRequest;
import org.springframework.data.domain.Pageable;
import org.springframework.data.domain.Sort;
import org.springframework.data.jpa.domain.Specification;
import org.springframework.stereotype.Service;
import lombok.extern.slf4j.Slf4j;

import javax.persistence.criteria.Predicate;
import java.lang.reflect.Field;
import java.util.*;

@Slf4j
@SuppressWarnings("DuplicatedCode")
@Service("application.admin.service.##region##.impl.##className##ServiceImpl")
public class ##className##ServiceImpl extends BaseServiceImpl implements ##className##Service<##className##Validate> {

    private ##className##Model ##parseClassName##_model;

    @Autowired
    public void set##className##Model(##className##Model ##parseClassName##_model) {
        this.##parseClassName##_model = ##parseClassName##_model;
    }

    @Override
    public Object extra() {
        Map<String, Object> map = new HashMap<>();##initialCode##
        return map;
    }

    @Override
    public boolean index(PageInput params) {
        int size = params.getLimit();
        int page = params.getOffset() / size;
        Pageable pageRequest = PageRequest.of(page, size);
        String field = params.getSort();
        String order = params.getOrder();
        if (!StringUtils.isEmpty(field)) {
            Sort.Direction direction = order.equals("asc") ? Sort.Direction.ASC : Sort.Direction.DESC;
            pageRequest = PageRequest.of(page, size, direction, field);
        }
        ##className## search = JSONObject.parseObject(JSONObject.toJSONString(params.getSearch()), ##className##.class);
        Specification<##className##> spe = (root, query, criteriaBuilder) -> {
            List<Predicate> predicates  = new ArrayList<>();
            try {
                for (Field f : search.getClass().getDeclaredFields()) {
                    f.setAccessible(true);
                    if (f.get(search) != null && StringUtils.isNotBlank(f.get(search).toString())) {
                        predicates.add(criteriaBuilder.like(root.get(f.getName()), "%" + f.get(search) + "%"));
                    }
                }
            } catch (Exception e) {
                e.printStackTrace();
            }
            return criteriaBuilder.and( predicates.toArray(new Predicate[0]));
        };
        super.result = ##parseClassName##_model.findAll(spe, pageRequest);
        return true;
    }

    @Override
    public boolean read(##className##Validate params) {
        Optional<##className##> optional = ##parseClassName##_model.findById(params.getId());
        if (optional.isEmpty()) {
            super.error = "参数：id 值错误！";
            return false;
        }
        super.result = optional.get();
        return true;
    }

    @Override
    public boolean save(##className##Validate params) {
        ##className## model = new ##className##();
        BeanUtils.copyProperties(params, model);
        model.setCreateTime(DateUtil.time());
        super.result = ##parseClassName##_model.save(model);
        return true;
    }

    @Override
    public boolean update(##className##Validate params) {
        Optional<##className##> optional = ##parseClassName##_model.findById(params.getId());
        if (optional.isEmpty()) {
            super.error = "参数：id 值错误！";
            return false;
        }
        ##className## model = optional.get();
        BeanUtils.copyProperties(params, model, Helper.getNullPropertyNames(params));
        model.setUpdateTime(DateUtil.time());
        super.result = ##parseClassName##_model.save(model);
        return true;
    }

    @Override
    public boolean status(##className##Validate params) {
        List<String> ids = new ArrayList<>();
        if (StringUtils.isNotBlank(params.getId())) {
            ids.add(params.getId());
        }
        if (params.getIds() != null && !params.getIds().isEmpty()) {
            ids.addAll(params.getIds());
        }
        Specification<##className##> spe = (root, query, criteriaBuilder) -> criteriaBuilder.in(root.get("id")).value(ids);
        List<##className##> update = ##parseClassName##_model.findAll(spe);
        update.forEach((model) -> model.setStatus(params.getStatus()));
        ##parseClassName##_model.saveAll(update);
        super.result = update.size();
        return true;
    }

    @Override
    public boolean delete(##className##Validate params) {
        List<String> ids = new ArrayList<>();
        if (StringUtils.isNotBlank(params.getId())) {
            ids.add(params.getId());
        }
        if (params.getIds() != null && !params.getIds().isEmpty()) {
            ids.addAll(params.getIds());
        }
        Specification<##className##> spe = (root, query, criteriaBuilder) -> criteriaBuilder.in(root.get("id")).value(ids);
        List<##className##> model = ##parseClassName##_model.findAll(spe);
        ##parseClassName##_model.deleteAll(model);
        super.result = model.size();
        return true;
    }
}
