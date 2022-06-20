<?php /** @noinspection DuplicatedCode */
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
// | Version: 2.0 2021/8/25 10:36
// +----------------------------------------------------------------------
namespace com\agf2\library\gen\java\admin;

use com\agf2\abs\lib\LibJavaAdminAbs;
use com\agf2\util\Helper;

class Entity extends LibJavaAdminAbs
{

    public function build(): string
    {
        $path = $this->adminConfig->getTemplate()->getJava()->getEntity();
        return $this->setTemplate($path)
                    ->replaceAll([
                                     'fields'   => self::fields($this->data),
                                     'acquirer' => self::get($this->data),
                                     'modifier' => self::set($this->data),
                                     'import'   => self::import($this->data)
                                 ])
                    ->getTemplate();
    }

    // 字段列表
    private static function fields(array &$data): string
    {
        $code      = [];
        $fields    = $data[0]['selected'][0]['fields'];
        $whitelist = ['id', 'sort', 'status', 'create_time', 'update_time'];
        foreach ($fields as $field) {
            if (!in_array($field['COLUMN_NAME'], $whitelist)) {
                $nullable  = $field['IS_NULLABLE'] === 'No' ? ', nullable = false' : '';
                $data_type = Helper::mysqlTypeToJavaType($field['DATA_TYPE']);
                self::cast($data, $data_type);
                $column_name  = parse_name($field['COLUMN_NAME'], 1, false);
                $default      = in_array(strtolower($field['DATA_TYPE']), ['blob', 'text', 'geometry', 'json']) ? '' : " DEFAULT '{$field['COLUMN_DEFAULT']}'";
                $code      [] = <<<java
    @Column(columnDefinition = "{$field['COLUMN_TYPE']}$default COMMENT '{$field['COLUMN_COMMENT']}'"$nullable)
    private $data_type $column_name;
java;

            }
        }
        return implode(PHP_EOL . PHP_EOL, $code);
    }

    // 根据控件对属性类型强制转换
    private static function cast(array &$data, string &$data_type): void
    {
        Helper::each($data, function ($val) use (&$data_type) {
            switch ((int)$val['type_id']) {
                case 9:
                case 6:
                    $data_type = 'String';
                    break;
                default:
            }
        });
    }

    // 获取器
    private static function get(array &$data): string
    {
        $code = [];
        Helper::each($data, function ($val) use (&$code) {
            $type_id    = (int)$val['type_id'];
            $uc_field   = parse_name($val['formData']['bindTableFiled'], 1);
            $field_name = parse_name($val['formData']['bindTableFiled'], 1, false);
            // 如果是多选或日期区间
            if ($type_id === 6) {
                $code[] = '
    /**
     * ' . $val['title'] . '获取器
     *
     * @return java.lang.String[]
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date ' . date('y/m/d H:i:s') . '
     */
    public String[] get' . $uc_field . '() {
        String[] value = JSONObject.parseObject(this.' . $field_name . ', String[].class);
        return value == null ? new String[0] : value;
    }
';
            } elseif ($type_id === 9 || $type_id === 14) { // 日期区间或编辑表格
                $code[] = '
    /**
     * ' . $val['title'] . '获取器
     *
     * @return java.lang.String[]
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date ' . date('y/m/d H:i:s') . '
     */
    public Map<String, Object> get' . $uc_field . '() {
        Map<String, Object> value = JSONObject.parseObject(this.' . $field_name . ', new TypeReference<>() {});
        return value == null ? new HashMap<>() : value;
    }
';
            } elseif ($type_id === 8) { // 日期
                $format = $val['formData']['dateFormat'] == 2 ? 'yyyy-MM-dd HH:mm' : 'yyyy-MM-dd';
                $code[] = '
    /**
     * ' . $val['title'] . '获取器
     *
     * @return java.lang.String
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date ' . date('y/m/d H:i:s') . '
     */
    public String get' . $uc_field . '() {
        return Getter.date(this.date, "' . $format . '");
    }
';
            } elseif ($type_id === 11) { // 单位组织
                // 人员/部门
                if ((int)$val['formData']['typeSelection'] === 3 || (int)$val['formData']['typeSelection'] === 2) {
                    $fieldName = parse_name($val['formData']['bindTableFiled'], 1);
                    $code[]    = '
    // ' . $val['title'] . '获取器
    public function get' . $fieldName . 'Attr($value)
    {
        return json_decode($value,true);
    }
';
                }
            } elseif ($type_id === 12) { // 当前信息
                // 当前用户
                if ((int)$val['formData']['typeSelection'] === 3) {
                    $fieldName = parse_name($val['formData']['bindTableFiled'], 1);
                    $code[]    = '
    // ' . $val['title'] . '获取器
    public function get' . $fieldName . 'TextAttr($value, $data)
    {
        unset($value);
        return get_nickname($data[\'' . $val['formData']['bindTableFiled'] . '\']);
    }
';
                }
            } elseif ($type_id === 13) { // 附件上传
                $code[] = '
    /**
     * ' . $val['title'] . '获取器
     *
     * @return java.util.List<com.dm.frame.database.migrations.File>
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date ' . date('y/m/d H:i:s') . '
     */
    public List<File> get' . $uc_field . '() {
        return Getter.file(this.' . $field_name . ');
    }
';
            } elseif ($type_id === 15) { // 图片上传
                $code[] = '
    /**
     * ' . $val['title'] . '获取器
     *
     * @return java.util.List<com.dm.frame.database.migrations.Picture>
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date ' . date('y/m/d H:i:s') . '
     */
    public List<Picture> get' . $uc_field . '() {
        return Getter.picture(this.' . $field_name . ');
    }
';
            }
        });
        return implode('', array_unique($code));
    }

    // 修改器
    private static function set(array &$data): string
    {
        $code = [];
        Helper::each($data, function ($val) use (&$code) {
            $type_id    = (int)$val['type_id'];
            $uc_field   = parse_name($val['formData']['bindTableFiled'], 1);
            $field_name = parse_name($val['formData']['bindTableFiled'], 1, false);
            // 如果是多选
            if ($type_id === 6) {
                $code[] = '
    /**
     * ' . $val['title'] . '修改器
     *
     * @param value java.lang.String
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date ' . date('y/m/d H:i:s') . '
     */
    public void set' . $uc_field . '(String[] value) {
        this.' . $field_name . ' = JSONObject.toJSONString(value);
    }
';
            } elseif ($type_id === 9 || $type_id === 14) { // 日期区间或编辑表格
                $code[] = '
    /**
     * ' . $val['title'] . '修改器
     *
     * @param value java.lang.String
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date ' . date('y/m/d H:i:s') . '
     */
    public void set' . $uc_field . '(Map<String, Object> value) {
        this.' . $field_name . ' = JSONObject.toJSONString(value);
    }
';
            } elseif ($type_id === 8) { // 日期
                $format = $val['formData']['dateFormat'] == 2 ? 'yyyy-MM-dd HH:mm' : 'yyyy-MM-dd';
                $code[] = '
    /**
     * ' . $val['title'] . '修改器
     *
     * @param value java.lang.String
     * @author TaoGe <liangtao.gz@foxmail.com>
     * @date ' . date('y/m/d H:i:s') . '
     */
    public void set' . $uc_field . '(String value) {
        this.date = Setter.' . $field_name . '(value, "' . $format . '");
    }
';
            }
        });
        return implode('', array_unique($code));
    }

    // 引用
    private static function import(array &$data): string
    {
        $code = [];
        Helper::each($data, function ($value) use (&$code) {
            switch ((int)$value['type_id']) {
                case 6: // 多选框
                    $code[] = 'import com.alibaba.fastjson.JSONObject;';
                    break;
                case 9: // 日期区间
                    $code[] = 'import java.util.Map;';
                    $code[] = 'import java.util.HashMap;';
                    $code[] = 'import com.alibaba.fastjson.JSONObject;';
                    $code[] = 'import com.alibaba.fastjson.TypeReference;';
                    break;
                case 8: // 日期
                    $code[] = 'import com.dm.frame.application.common.util.Setter;';
                    $code[] = 'import com.dm.frame.application.common.util.Getter;';
                    break;
                case 13: // 附件上传
                case 15: // 图片上传
                    $code[] = 'import java.util.List;';
                    $code[] = 'import com.dm.frame.application.common.util.Getter;';
                    break;
            }
        });
        return Helper::format($code);
    }
}
