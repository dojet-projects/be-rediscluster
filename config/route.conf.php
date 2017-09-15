<?php

Dispatcher::loadRoute(
    [
    '/^$/' => UI.'HomeAction',
    '/^ajax\/server\/add$/' => UI.'AjaxServerAddAction',
    '/^ajax\/cluster\/nodes$/' => UI.'AjaxClusterNodesAction',
    '/^ajax\/cluster\/meet$/' => UI.'AjaxClusterMeetAction',
    '/^ajax\/cluster\/forget$/' => UI.'AjaxClusterForgetAction',

    '/^node\/(?<id>.*)$/' => UI.'node/NodeAction',
    '/^test$/' => UI.'TestAction',
    ]
);
