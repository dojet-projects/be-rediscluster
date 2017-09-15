<?php
/**
 *
 * Filename: AjaxClusterNodesAction.class.php
 *
 * @author liyan
 * @since 2017 9 13
 */
class AjaxClusterNodesAction extends RCBaseAction {

    protected function rcExecute(DRedisIns $redis) {
        $data = Cluster::fromRedis($redis)->toArray();
        return $this->displayJsonSuccess($data);
    }

    protected function redis_error(Exception $e) {
        return $this->displayJsonFail([], $e->getMessage());
    }

}
