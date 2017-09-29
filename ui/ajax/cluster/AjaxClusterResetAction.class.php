<?php
/**
 *
 * Filename: AjaxClusterResetAction.class.php
 *
 * @author liyan
 * @since 2017 9 28
 */
class AjaxClusterResetAction extends RCBaseAction {

    protected function rcExecute(Cluster $cluster) {
        $id = MRequest::post('id');

        $node = $cluster->node($id);
        if (is_null($node)) {
            return $this->displayJsonFail('node not exists');
        }

        try {
            $ret = $node->reset('soft');
        } catch (DRedisException $e) {
            if ($e->getCode() == DRedisException::REPLY_ERROR) {
                return $this->displayJsonFail(null, $e->getMessage());
            }
        }

        return $this->displayJsonSuccess();
    }

}
