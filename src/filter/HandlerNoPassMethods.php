<?php
namespace AutoTest\Filter;

/*
 * handler接口
 * @author arrayhua<2498168786@qq.com>
 * @date: 2018-08-08
 * @copyright arrayhua.github.io
 */
class HandlerNoPassMethods extends Handler
{
    /**
     * 校验方法
     * @param Filter $filter
     * @return bool
     */
    public function check(Filter $filter)
    {
        if ($filter->noPassMethods) {
            if (in_array($filter->currentPathKey, $filter->noPassMethods)) {
                return false;
            }
        }
        return true;
    }
}
