<?php
/**
 *
 * Filename: AjaxClusterDelSlotsAction.class.php
 *
 * @author liyan
 * @since 2017 9 15
 */
class AjaxClusterDelSlotsAction extends RCBaseAction {

    protected function rcExecute(Cluster $cluster) {
        $id = MRequest::post('id');
        $slots = MRequest::post('slots');

        try {
            $slots = explode(',', $slots);
            $ret = $cluster->delslots($slots);
        } catch (DRedisException $e) {
            if ($e->getCode() == DRedisException::REPLY_ERROR) {
                return $this->displayJsonFail(null, $e->getMessage());
            }
        }

        return $this->displayJsonSuccess();
    }

}
