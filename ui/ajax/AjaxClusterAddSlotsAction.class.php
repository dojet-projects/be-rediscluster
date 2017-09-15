<?php
/**
 *
 * Filename: AjaxClusterAddSlotsAction.class.php
 *
 * @author liyan
 * @since 2017 9 15
 */
class AjaxClusterAddSlotsAction extends RCBaseAction {

    protected function rcExecute(DRedisIns $redis) {
        $id = MRequest::post('id');
        $slots = MRequest::post('slots');

        $cluster = Cluster::fromRedis($redis);
        $node = $cluster->node($id);
        if (is_null($node)) {
            return $this->displayJsonFail('node not exists');
        }

        $slots = array_map(function($s) {
            return trim($s);
        }, explode(",", $slots));
        DAssert::assertNotEmptyNumericArray($slots);

        try {
            $ret = $node->addslots($slots);
        } catch (DRedisException $e) {
            if ($e->getCode() == DRedisException::REPLY_ERROR) {
                return $this->displayJsonFail(null, $e->getMessage());
            }
        }

        return $this->displayJsonSuccess();
    }

}
