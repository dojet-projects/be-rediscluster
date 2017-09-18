<?php
/**
 * Homepage
 *
 * Filename: RCBaseAction.class.php
 *
 * @author liyan
 * @since 2017 9 11
 */
require_once GLUTIL.'redis/require.inc.php';

abstract class RCBaseAction extends XBaseAction {

    final public function execute() {
        $node = Config::runtimeConfigForKeyPath('cluster.node');
        try {
            $redis = DRedisIns::redis($node);
            $cluster = Cluster::fromRedis($redis);
        } catch (Exception $e) {
            return $this->redis_error($e);
        }

        $this->rcExecute($cluster);
    }

    abstract protected function rcExecute(Cluster $cluster);

    protected function redis_error(Exception $e) {

    }

}
