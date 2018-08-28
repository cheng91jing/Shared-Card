<?php
/**
 * Created by PhpStorm.
 * Project by SharedCard.
 * User: Chen
 * Date: 2018/8/20
 * Time: 16:15
 * Email: 654807719@qq.com
 */

namespace app\common\model;


use think\db\Query;
use think\Model;
use think\Request;

abstract class Base extends Model
{

    public static function gridPaginateFormat(Query $query)
    {
        $rows = Request::instance()->request('rows', 10);
        $page = Request::instance()->request('page', 1);
        $result = $query->paginate([
            'list_rows' => $rows,
            'page' => $page,
        ]);
        return [
            'page' => $result->currentPage(),
            'rows' => $result->getCollection(),
            'total' => $result->lastPage(),
            'records' => $result->total()
        ];
    }

    /**
     * 已废弃
     * JQGrid 分页
     * @param Query $query
     *
     * @return array
     */
    public static function gridSort(Query $query)
    {
        $sidx = Request::instance()->request('sidx', null);
        $sord = Request::instance()->request('sord', 'DESC');
        if (!empty($sidx)){
            $query->order($sidx . ' ' . $sord);
        }
        return self::gridPaginateFormat($query);
    }

    /**
     * 分页
     * @param array $wheres 条件数组
     * @param array $scopes 查询范围
     * @param array $with 关联预载入
     * @param null|string $order 排序
     *
     * @return array
     */
    public static function paginateScope($wheres = [], $scopes = [], $with = [], $order = null)
    {
        $query = static::scope($scopes)->with($with)->where($wheres);
        if($order !== null) $query->order($order);
        return self::gridPaginateFormat($query);
    }
}