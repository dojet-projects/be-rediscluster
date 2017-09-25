<?php

Dispatcher::loadRoute(
    [
    '/^$/' => UI.'HomeAction',
    // '/^ajax\/server\/add$/' => UI.'ajax/AjaxServerAddAction',
    '/^ajax\/cluster\/nodes$/' => UI.'ajax/cluster/AjaxClusterNodesAction',
    '/^ajax\/cluster\/meet$/' => UI.'ajax/cluster/AjaxClusterMeetAction',
    '/^ajax\/cluster\/forget$/' => UI.'ajax/cluster/AjaxClusterForgetAction',
    '/^ajax\/cluster\/addslots$/' => UI.'ajax/cluster/AjaxClusterAddSlotsAction',
    '/^ajax\/cluster\/delslots$/' => UI.'ajax/cluster/AjaxClusterDelSlotsAction',
    '/^ajax\/cluster\/migrate\-slot$/' => UI.'ajax/cluster/AjaxClusterSlotMigrateAction',
    '/^ajax\/cluster\/slots$/' => UI.'ajax/cluster/AjaxClusterSlotsAction',
    '/^ajax\/resharding\/plan$/' => UI.'ajax/resharding/AjaxReshardPlanAction',
    '/^ajax\/resharding\/reshard$/' => UI.'ajax/resharding/AjaxReshardAction',

    '/^node\/(?<id>.*)$/' => UI.'node/NodeAction',
    '/^test$/' => UI.'TestAction',
    ]
);
