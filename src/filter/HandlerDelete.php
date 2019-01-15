<?php
namespace AutoTest\Filter;

/*
 * handler接口
 * @author arrayhua<2498168786@qq.com>
 * @date: 2018-08-08
 * @copyright arrayhua.github.io
 */
class HandlerDelete extends Handler
{
    /**
     * Delete
     * @param Filter $filter
     * @return bool
     */
    public function check(Filter $filter)
    {
        if ($filter->currentPath->delete) {

            $filter->http->name     = $filter->currentPath->delete->summary;
            $filter->http->url      = $filter->swagger->getCurrentUrl($filter->currentPath->path);
            $filter->http->params   = $filter->swagger->getCurrentParams($filter->currentPath->delete->parameters);
            $filter->http->post();

            return $filter->http;
        }
    }
}
