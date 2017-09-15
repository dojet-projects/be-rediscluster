<?php

Dispatcher::loadRoute(
    [
    '/^$/' => UI.'HomeAction',
    '/^ajax\/server\/add$/' => UI.'ajax/AjaxServerAddAction',
    '/^ajax\/cluster\/nodes$/' => UI.'ajax/AjaxClusterNodesAction',
    '/^ajax\/cluster\/meet$/' => UI.'ajax/AjaxClusterMeetAction',
    '/^ajax\/cluster\/forget$/' => UI.'ajax/AjaxClusterForgetAction',
    '/^ajax\/cluster\/addslots$/' => UI.'ajax/AjaxClusterAddSlotsAction',
    '/^ajax\/cluster\/slots$/' => UI.'ajax/AjaxClusterSlotsAction',

    '/^node\/(?<id>.*)$/' => UI.'node/NodeAction',
    '/^test$/' => UI.'TestAction',
    ]
);
