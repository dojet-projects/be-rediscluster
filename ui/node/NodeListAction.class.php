<?php
/**
 *
 * Filename: NodeListAction.class.php
 *
 * @author liyan
 * @since 2017 9 29
 */
class NodeListAction extends RCBaseAction {

    protected function rcExecute(Cluster $cluster) {
        $nodes = $cluster->nodes();
        $this->assign('nodes', $nodes);
        $this->displayTemplate('node/nodelist.tpl.php');
    }

}
