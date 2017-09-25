<?php
/**
 *
 * Filename: AjaxClusterNodesAction.class.php
 *
 * @author liyan
 * @since 2017 9 13
 */
class AjaxClusterNodesAction extends RCBaseAction {

    protected function rcExecute(Cluster $cluster) {
        $data = $cluster->toArray();
        return $this->displayJsonSuccess($data);
    }

    protected function redis_error(Exception $e) {
        return $this->displayJsonFail([], $e->getMessage());
    }

}
