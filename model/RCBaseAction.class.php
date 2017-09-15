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
        $node = Config::configForKeyPath('cluster.node');
        try {
            $redis = DRedisIns::redis($node);
        } catch (Exception $e) {
            return $this->redis_error($e);
        }

        $this->rcExecute($redis);
    }

    abstract protected function rcExecute(DRedisIns $redis);

    protected function redis_error(Exception $e) {

    }

}
