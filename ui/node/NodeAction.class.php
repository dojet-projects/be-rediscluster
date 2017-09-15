<?php
/**
 *
 * Filename: NodeAction.class.php
 *
 * @author liyan
 * @since 2017 9 13
 */
class NodeAction extends RCBaseAction {

    protected function rcExecute(DRedisIns $redis) {
        $id = MRequest::param('id');

        $info = $redis->info();

        $this->assign('node_id', $id);
        $this->assign('info', $info);
        $this->displayTemplate('node/node.tpl.php');
    }

}
