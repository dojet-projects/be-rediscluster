<?php
/**
 *
 * Filename: AjaxClusterSlotsAction.class.php
 *
 * @author liyan
 * @since 2017 9 15
 */
class AjaxClusterSlotsAction extends RCBaseAction {

    protected function rcExecute(Cluster $cluster) {
        $id = MRequest::post('id');

        $node = $cluster->node($id);
        if (is_null($node)) {
            return $this->displayJsonFail('node not exists');
        }

        try {
            $ret = $node->slots();
        } catch (DRedisException $e) {
            if ($e->getCode() == DRedisException::REPLY_ERROR) {
                return $this->displayJsonFail(null, $e->getMessage());
            }
        }

        $data = ['slots' => $ret];
        return $this->displayJsonSuccess($data);
    }

}
