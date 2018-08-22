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
            'total' => $result->total(),
            'records' => $result->lastPage()
        ];
    }

    public static function gridSort(Query $query)
    {
        $sidx = Request::instance()->request('sidx', null);
        $sord = Request::instance()->request('sord', 'DESC');
        if (!empty($sidx)){
            $query->order($sidx . ' ' . $sord);
        }
        return self::gridPaginateFormat($query);
    }

    /*分页*/
    public static function paginateScope($wheres = [], $scopes = [])
    {
        return self::gridSort(static::scope($scopes)->where($wheres));
    }
}