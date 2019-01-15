<?php
namespace AutoTest\Filter;

/*
 * handler接口
 * @author arrayhua<2498168786@qq.com>
 * @date: 2018-08-08
 * @copyright arrayhua.github.io
 */
class HandlerPut extends Handler
{
    /**
     * Put
     * @param Filter $filter
     * @return bool
     */
    public function check(Filter $filter)
    {
        if ($filter->currentPath->put) {

            $filter->http->name     = $filter->currentPath->put->summary;
            $filter->http->url      = $filter->swagger->getCurrentUrl($filter->currentPath->path);
            $filter->http->params   = $filter->swagger->getCurrentParams($filter->currentPath->put->parameters);
            $filter->http->put();

            return $filter->http;
        }
    }
}
