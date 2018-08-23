<?php
/**
 * Created by PhpStorm.
 * Project by SharedCard.
 * User: Chen
 * Date: 2018/8/20
 * Time: 17:15
 * Email: 654807719@qq.com
 */

namespace app\common\library\tag;

use think\template\TagLib;

class Auth extends TagLib
{
    /**
     * 定义标签列表
     */
    protected $tags   =  [
        // 标签定义： attr 属性列表 close 是否闭合（0 或者1 默认1） alias 标签别名 level 嵌套层次
        'can'     => ['attr' => 'action', 'close' => 1], //闭合标签，默认为不闭合
//        'open'      => ['attr' => 'name,type', 'close' => 1],

    ];

    /**
     * 权限判断
     *
     * @param $tag array 属性
     * @param $content string 内容
     *
     * @return string
     */
    public function tagCan($tag, $content)
    {
        $permission_class = '\app\common\library\PermissionHandler';
        $parse = "<?php if({$permission_class}::can(\"{$tag['action']}\")){ ?>";
        $parse .= $content;
        $parse .= '<?php }?>';
        return $parse;
    }

    /**
     * 这是一个非闭合标签的简单演示
     */
//    public function tagOpen($tag, $content)
//    {
//        $type = empty($tag['type']) ? 0 : 1; // 这个type目的是为了区分类型，一般来源是数据库
//        $name = $tag['name']; // name是必填项，这里不做判断了
//        $parse = '<?php ';
//        $parse .= '$test_arr=[[1,3,5,7,9],[2,4,6,8,10]];'; // 这里是模拟数据
//        $parse .= '$__LIST__ = $test_arr[' . $type . '];';
/*        $parse .= ' ?>';*/
//        $parse .= '{volist name="__LIST__" id="' . $name . '"}';
//        $parse .= $content;
//        $parse .= '{/volist}';
//        return $parse;
//    }
}