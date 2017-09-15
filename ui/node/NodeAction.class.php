<?php
/**
 *
 * Filename: NodeAction.class.php
 *
 * @author liyan
 * @since 2017 9 13
 */
class NodeAction extends RCBaseAction {

    protected function rcExecute(Cluster $cluster) {
        $id = MRequest::param('id');

        $node = $cluster->node($id);
        if (is_null($node)) {
            print 'node not exists';
            return;
        }
        $info = $node->redis_info();

        $this->assign('node_id', $id);
        $this->assign('info', $info);
        $this->displayTemplate('node/node.tpl.php');
    }

}
