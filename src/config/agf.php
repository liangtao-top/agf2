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
// | Version: 2.0 2021/8/20 8:53
// +----------------------------------------------------------------------

// 定义AGF根路径
!defined("AGF_ROOT") && define("AGF_ROOT", dirname(__DIR__));
!defined("DS") && define("DS", DIRECTORY_SEPARATOR);

return [
    'php'  => [
        'admin' => [
            'template' => [
                'php'  => [
                    'controller' => AGF_ROOT . DS . 'template' . DS . 'php' . DS . 'admin' . DS . 'php' . DS . 'controller.tpl',
                    'logic'      => AGF_ROOT . DS . 'template' . DS . 'php' . DS . 'admin' . DS . 'php' . DS . 'logic.tpl',
                    'model'      => AGF_ROOT . DS . 'template' . DS . 'php' . DS . 'admin' . DS . 'php' . DS . 'model.tpl',
                    'validate'   => AGF_ROOT . DS . 'template' . DS . 'php' . DS . 'admin' . DS . 'php' . DS . 'validate.tpl',
                ],
                'html' => [
                    'index'     => AGF_ROOT . DS . 'template' . DS . 'php' . DS . 'admin' . DS . 'html' . DS . 'index.tpl',
                    'form'      => AGF_ROOT . DS . 'template' . DS . 'php' . DS . 'admin' . DS . 'html' . DS . 'form.tpl',
                    'form_tabs' => AGF_ROOT . DS . 'template' . DS . 'php' . DS . 'admin' . DS . 'html' . DS . 'form_tabs.tpl',
                    'view'      => AGF_ROOT . DS . 'template' . DS . 'php' . DS . 'admin' . DS . 'html' . DS . 'view.tpl',
                ],
                'css'  => [
                    'index' => AGF_ROOT . DS . 'template' . DS . 'php' . DS . 'admin' . DS . 'css' . DS . 'index.tpl',
                    'form'  => AGF_ROOT . DS . 'template' . DS . 'php' . DS . 'admin' . DS . 'css' . DS . 'form.tpl',
                    'view'  => AGF_ROOT . DS . 'template' . DS . 'php' . DS . 'admin' . DS . 'css' . DS . 'view.tpl',
                ],
                'js'   => [
                    'index' => AGF_ROOT . DS . 'template' . DS . 'php' . DS . 'admin' . DS . 'js' . DS . 'index.tpl',
                    'form'  => AGF_ROOT . DS . 'template' . DS . 'php' . DS . 'admin' . DS . 'js' . DS . 'form.tpl',
                    'view'  => AGF_ROOT . DS . 'template' . DS . 'php' . DS . 'admin' . DS . 'js' . DS . 'view.tpl',
                ],
            ],
        ],
        'api'   => [
            'template' => [
                'php' => [
                    'controller' => AGF_ROOT . DS . 'template' . DS . 'php' . DS . 'api' . DS . 'php' . DS . 'controller.tpl',
                    'logic'      => AGF_ROOT . DS . 'template' . DS . 'php' . DS . 'api' . DS . 'php' . DS . 'logic.tpl',
                    'model'      => AGF_ROOT . DS . 'template' . DS . 'php' . DS . 'api' . DS . 'php' . DS . 'model.tpl',
                    'validate'   => AGF_ROOT . DS . 'template' . DS . 'php' . DS . 'api' . DS . 'php' . DS . 'validate.tpl',
                ],
            ],
        ],
    ],
    'java' => [
        'admin' => [
            'template' => [
                'java' => [
                    'controller'   => AGF_ROOT . DS . 'template' . DS . 'java' . DS . 'admin' . DS . 'java' . DS . 'Controller.java',
                    'service'      => AGF_ROOT . DS . 'template' . DS . 'java' . DS . 'admin' . DS . 'java' . DS . 'Service.java',
                    'service_impl' => AGF_ROOT . DS . 'template' . DS . 'java' . DS . 'admin' . DS . 'java' . DS . 'ServiceImpl.java',
                    'model'        => AGF_ROOT . DS . 'template' . DS . 'java' . DS . 'admin' . DS . 'java' . DS . 'Model.java',
                    'validate'     => AGF_ROOT . DS . 'template' . DS . 'java' . DS . 'admin' . DS . 'java' . DS . 'Validate.java',
                    'entity'       => AGF_ROOT . DS . 'template' . DS . 'java' . DS . 'admin' . DS . 'java' . DS . 'Entity.java',
                ],
                'html' => [
                    'index'     => AGF_ROOT . DS . 'template' . DS . 'java' . DS . 'admin' . DS . 'html' . DS . 'index.tpl',
                    'form'      => AGF_ROOT . DS . 'template' . DS . 'java' . DS . 'admin' . DS . 'html' . DS . 'form.tpl',
                    'form_tabs' => AGF_ROOT . DS . 'template' . DS . 'java' . DS . 'admin' . DS . 'html' . DS . 'form_tabs.tpl',
                    'view'      => AGF_ROOT . DS . 'template' . DS . 'java' . DS . 'admin' . DS . 'html' . DS . 'view.tpl',
                ],
                'css'  => [
                    'index' => AGF_ROOT . DS . 'template' . DS . 'java' . DS . 'admin' . DS . 'css' . DS . 'index.tpl',
                    'form'  => AGF_ROOT . DS . 'template' . DS . 'java' . DS . 'admin' . DS . 'css' . DS . 'form.tpl',
                    'view'  => AGF_ROOT . DS . 'template' . DS . 'java' . DS . 'admin' . DS . 'css' . DS . 'view.tpl',
                ],
                'js'   => [
                    'index' => AGF_ROOT . DS . 'template' . DS . 'java' . DS . 'admin' . DS . 'js' . DS . 'index.tpl',
                    'form'  => AGF_ROOT . DS . 'template' . DS . 'java' . DS . 'admin' . DS . 'js' . DS . 'form.tpl',
                    'view'  => AGF_ROOT . DS . 'template' . DS . 'java' . DS . 'admin' . DS . 'js' . DS . 'view.tpl',
                ],
            ],
        ],
        'api'   => [
            'template' => [
                'java' => [],
            ],
        ],
    ],
];
