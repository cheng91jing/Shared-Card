<?php

namespace app\common\model;
use think\Exception;


/**
 * Class GoodsCategory
 * @property int cat_id
 * @property string cat_name 商品名称
 * @property integer parent_id 父级分类
 * @property integer cat_level 分类层级
 * @property integer is_parent 是否可以新增下级分类
 * @property integer cat_sort 排序
 * @property integer is_show 是否显示
 */
class GoodsCategory extends Base
{
    protected $autoWriteTimestamp = false;

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id', 'cat_id')->order('cat_sort');
    }

    /**
     * 获取商品分类关系列表
     */
    public static function getRelationList()
    {
        $cat = (new self)->with('children.children')->where(['parent_id' => 0])->order('cat_sort')->select();
        return $cat;
    }

    /**
     * 分类批量操作
     * @param array $list 分类列表
     * @param int $parent_id 父级分类
     * @param int $level 层级
     *
     * @throws Exception
     * @throws \think\exception\DbException
     */
    public static function catListChange(array $list, $parent_id = 0, $level = 1)
    {
        foreach ($list as $k => $cat){
            $model = self::get($cat['id']);
            if(empty($model)) throw new Exception('ID为：' . $cat['id'] . '。的分类未找到！');
            $model->parent_id = $parent_id;
            $model->cat_sort = intval($k) + 1;
            $model->cat_level = $level;
            $model->is_parent = ($level == 3) ? false : true;
            $model->save();
            if(!empty($cat['children']))
                self::catListChange($cat['children'], $model->cat_id, $model->cat_level + 1);
        }
    }

}