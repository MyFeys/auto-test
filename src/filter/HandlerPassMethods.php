<?php
namespace AutoTest\Filter;

/*
 * handler接口
 * @author arrayhua<2498168786@qq.com>
 * @date: 2018-08-08
 * @copyright arrayhua.github.io
 */
class HandlerPassMethods extends Handler
{
    /**
     * 校验方法
     * @param Filter $filter
     * @return bool
     */
    public function check(Filter $filter)
    {
        if ($filter->passMethods) {
            if (!in_array($filter->currentPathKey, $filter->passMethods)) {
                return false;
            }
        }
        return true;
    }
}
