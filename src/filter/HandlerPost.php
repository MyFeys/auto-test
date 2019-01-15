<?php
namespace AutoTest\Filter;

/*
 * handler接口
 * @author arrayhua<2498168786@qq.com>
 * @date: 2018-08-08
 * @copyright arrayhua.github.io
 */
class HandlerPost extends Handler
{
    /**
     * Post
     * @param Filter $filter
     * @return bool
     */
    public function check(Filter $filter)
    {
        if ($filter->currentPath->post) {

            $filter->http->name     = $filter->currentPath->post->summary;
            $filter->http->url      = $filter->swagger->getCurrentUrl($filter->currentPath->path);
            $filter->http->params   = $filter->swagger->getCurrentParams($filter->currentPath->post->parameters);
            $filter->http->post();

            return $filter->http;
        }
    }
}
