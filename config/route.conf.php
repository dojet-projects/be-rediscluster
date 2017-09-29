<?php

Dispatcher::loadRoute(
    [
    '/^$/' => UI.'HomeAction',

    '/^ajax\/cluster\/nodes$/' => UI.'ajax/cluster/AjaxClusterNodesAction',
    '/^ajax\/cluster\/meet$/' => UI.'ajax/cluster/AjaxClusterMeetAction',
    '/^ajax\/cluster\/forget$/' => UI.'ajax/cluster/AjaxClusterForgetAction',
    '/^ajax\/cluster\/addslots$/' => UI.'ajax/cluster/AjaxClusterAddSlotsAction',
    '/^ajax\/cluster\/delslots$/' => UI.'ajax/cluster/AjaxClusterDelSlotsAction',
    '/^ajax\/cluster\/migrate\-slot$/' => UI.'ajax/cluster/AjaxClusterSlotMigrateAction',
    '/^ajax\/cluster\/slots$/' => UI.'ajax/cluster/AjaxClusterSlotsAction',
    '/^ajax\/cluster\/replicate$/' => UI.'ajax/cluster/AjaxClusterReplicateAction',
    '/^ajax\/cluster\/reset$/' => UI.'ajax/cluster/AjaxClusterResetAction',
    '/^ajax\/resharding\/plan$/' => UI.'ajax/resharding/AjaxReshardPlanAction',
    '/^ajax\/resharding\/reshard$/' => UI.'ajax/resharding/AjaxReshardAction',

    '/^ajax\/nodeinfo$/' => UI.'ajax/AjaxNodeInfoAction',

    '/^node\/(?<id>.*)$/' => UI.'node/NodeAction',
    '/^nodelist$/' => UI.'node/NodeListAction',

    '/^test$/' => UI.'TestAction',
    ]
);
