<?php
namespace AutoTest\Filter;

use AutoTest\Lib\SwaggerAnalyze;

/*
 * handler接口
 * @author arrayhua<2498168786@qq.com>
 * @date: 2018-08-08
 * @copyright arrayhua.github.io
 */
class HandlerPassTags extends Handler
{
    /**
     * 校验方法
     * @param Filter $filter
     * @return bool
     */
    public function check(Filter $filter)
    {
        if ($filter->passTags) {
            foreach ($filter->currentPathTags as $tag) {
                if (!in_array($tag, $filter->passTags)) {
                    return false;
                }
            }
        }

        return true;
    }
}
