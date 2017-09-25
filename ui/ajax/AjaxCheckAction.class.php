<?php
/**
 *
 * Filename: AjaxCheckAction.class.php
 *
 * @author liyan
 * @since 2017 9 25
 */
class AjaxCheckAction extends RCBaseAction {

    protected function rcExecute(Cluster $cluster) {
        $data = [];
        $nodes = $cluster->nodes();
        $cluster_info = [];
        foreach ($nodes as $node) {
            $id = $node->id();
            if (!isset($cluster_info[$id])) {
                $cluster_info[$id] = $node;
                continue;
            }

            if (!$node->sameWith($cluster_info[$id])) {
                return $this->displayJsonFail(null, "[ERR] Nodes don't agree about configuration!");
            }
        }

        $data['cluster_info'] = $cluster->toArray();

        return $this->displayJsonSuccess($data);
    }

}
