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
// | Version: 2.0 2021/8/24 15:14
// +----------------------------------------------------------------------
namespace com\agf2\traits;

use com\agf2\util\Helper;

trait Search
{

    protected static function each(array &$data, callable $fun)
    {
        $form  = $data[2]['form'] ?? [];
        $array = $data[2]['data'] ?? [];
        if (isset($form['search']) && !empty($form['search']) && is_array($form['search']) && !empty($array) && is_array($array)) {
            foreach ($array as $val) {
                foreach ($form['search'] as $value) {
                    if ((int)$val['id'] === (int)$value['id']) {
                        $field = Helper::getFieldAttr($value['field'], $data);
                        $fun($value, $field);
                        break;
                    }
                }
            }
        }
    }

}
