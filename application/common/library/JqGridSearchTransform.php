<?php
/**
 * JqGrid 插件开启搜索后条件转换规则
 */

namespace app\common\library;


class JqGridSearchTransform
{

    private static function expression($rule)
    {
        switch ($rule['op'])
        {
            case 'eq':  //等于
                $where_arr = [$rule['field'], 'EQ', $rule['data']];
                break;
            case 'ne':  //不等于
                $where_arr = [$rule['field'], 'NEQ', $rule['data']];
                break;
            case 'lt':  //小于
                $where_arr = [$rule['field'], 'LT', $rule['data']];
                break;
            case 'le':  //小于等于
                $where_arr = [$rule['field'], 'ELT', $rule['data']];
                break;
            case 'gt':  //大于
                $where_arr = [$rule['field'], 'GT', $rule['data']];
                break;
            case 'ge':  //大于等于
                $where_arr = [$rule['field'], 'EGT', $rule['data']];
                break;
            case 'bw':  //开始于
                $where_arr = [$rule['field'], 'LIKE', $rule['data']. '%'];
                break;
            case 'bn':  //不开始于
                $where_arr = [$rule['field'], 'NOT LIKE', $rule['data']. '%'];
                break;
            case 'in':  //属于
                $where_arr = [$rule['field'], 'IN', $rule['data']];
                break;
            case 'ni':  //不属于
                $where_arr = [$rule['field'], 'NOT IN', $rule['data']];
                break;
            case 'ew':  //结束于
                $where_arr = [$rule['field'], 'LIKE', '%' .$rule['data']];
                break;
            case 'en':  //不结束于
                $where_arr = [$rule['field'], 'NOT LIKE', '%' .$rule['data']];
                break;
            case 'cn':  //包含 LIKE
                $where_arr = [$rule['field'], 'LIKE', '%' .$rule['data']. '%'];
                break;
            case 'nc':  //不包含 NOT LIKE
                $where_arr = [$rule['field'], 'NOT LIKE', '%' .$rule['data']. '%'];
                break;
            case 'nu':  //不存在
                $where_arr = [$rule['field'], 'NULL'];
                break;
            case 'nn':  //存在
                $where_arr = [$rule['field'], 'NOT NULL'];
                break;
            default:
                $where_arr = [];
        }
        return $where_arr;
    }

    public static function searchConditionSQL($filters)
    {
        //$filters_arr = json_decode($filters, true);
        if(!$filters) return false;
        $Param = [];
        foreach ($filters as $rule){
            $where = self::expression($rule);
            if($where) $Param[] = $where;
        }
        return $Param;
    }
}