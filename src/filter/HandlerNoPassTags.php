<?php
namespace AutoTest\Filter;

/*
 * handler接口
 * @author arrayhua<2498168786@qq.com>
 * @date: 2018-08-08
 * @copyright arrayhua.github.io
 */
class HandlerNoPassTags extends Handler
{
    /**
     * 校验方法
     * @param Filter $filter
     * @return bool
     */
    public function check(Filter $filter)
    {
        if ($filter->noPassTags) {
            foreach ($filter->currentPathTags as $tag) {
                if (in_array($tag, $filter->noPassTags)) {
                    return false;
                }
            }
        }

        return true;

    }
}
