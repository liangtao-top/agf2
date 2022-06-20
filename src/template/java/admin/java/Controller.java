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
package com.dm.frame.application.admin.controller.##region##;

import com.dm.frame.application.admin.common.BaseController;
import com.dm.frame.application.admin.service.##region##.##className##Service;
import com.dm.frame.application.common.util.Input;
import com.dm.frame.application.common.util.Result;
import com.dm.frame.application.common.util.Validate;
import com.dm.frame.application.admin.validate.##region##.##className##Validate;
import com.dm.frame.application.common.validate.PageInput;
import lombok.extern.slf4j.Slf4j;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.validation.annotation.Validated;
import org.springframework.web.bind.annotation.*;

@Slf4j
@RequestMapping("/##className##")
@Controller("application.admin.controller.##region##.##className##")
public class ##className## extends BaseController {

    private ##className##Service<##className##Validate> service;

    @Autowired
    public void setService(##className##Service<##className##Validate> service) {
        this.service = service;
    }

    @GetMapping("index")
    public String index(Model model, PageInput params) {
        if (Input.isAjax()) {
            boolean result = service.index(params);
            if (!result) {
                Result.error(service.getError());
            }
            Result.success(service.getResult());
        }
        model.addAttribute("data", service.extra());
        this.setWebTitle(model, "##functionName##列表");
        return "##region##/##parseClassName##/index";
    }

    @GetMapping("create")
    public String create(Model model) {
        model.addAttribute("data", service.extra());
        this.setWebTitle(model, "新增##functionName##");
        return "##region##/##parseClassName##/create";
    }

    @PostMapping("save")
    public void save(@Validated(##className##Validate.save.class) @RequestBody ##className##Validate params) {
        boolean result = service.save(params);
        if (!result) {
            Result.error(service.getError());
        }
        Result.success("新增成功");
    }

    @GetMapping("read")
    public String read(Model model, ##className##Validate params) {
        Validate.group(params, ##className##Validate.read.class);
        boolean result = service.read(params);
        if (!result) {
            Result.error(service.getError());
        }
        model.addAttribute("info", service.getResult());
        model.addAttribute("data", service.extra());
        this.setWebTitle(model, "查看##functionName##");
        return "##region##/##parseClassName##/read";
    }

    @GetMapping("edit")
    public String edit(Model model, ##className##Validate params) {
        Validate.group(params, ##className##Validate.edit.class);
        boolean result = service.read(params);
        if (!result) {
            Result.error(service.getError());
        }
        model.addAttribute("info", service.getResult());
        model.addAttribute("data", service.extra());
        this.setWebTitle(model, "编辑##functionName##");
        return "##region##/##parseClassName##/edit";
    }

    @PutMapping("update")
    public void update(@Validated(##className##Validate.update.class) @RequestBody ##className##Validate params) {
        boolean result = service.update(params);
        if (!result) {
            Result.error(service.getError());
        }
        Result.success("保存成功");
    }

    @PatchMapping("status")
    public void status(@Validated(##className##Validate.status.class) @RequestBody ##className##Validate params) {
        boolean result = service.status(params);
        if (!result) {
            Result.error(service.getError());
        }
        Result.success((params.getStatus() == 1 ? "启用" : "禁用") + "成功");
    }

    @DeleteMapping("delete")
    public void delete(@Validated(##className##Validate.delete.class) @RequestBody ##className##Validate params) {
        boolean result = service.delete(params);
        if (!result) {
            Result.error(service.getError());
        }
        Result.success("删除成功", service.getResult());
    }
}
