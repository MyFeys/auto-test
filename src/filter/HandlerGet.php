<?php
namespace AutoTest\Filter;

/*
 * handler接口
 * @author arrayhua<2498168786@qq.com>
 * @date: 2018-08-08
 * @copyright arrayhua.github.io
 */
class HandlerGet extends Handler
{
    /**
     * Get
     * @param Filter $filter
     * @return bool
     */
    public function check(Filter $filter)
    {
        if ($filter->currentPath->get) {

            $filter->http->name     = $filter->currentPath->get->summary;
            $filter->http->url      = $filter->swagger->getCurrentUrl($filter->currentPath->path);
            $filter->http->params   = $filter->swagger->getCurrentParams($filter->currentPath->get->parameters);
            $filter->http->get();

            return $filter->http;
        }
    }
}
