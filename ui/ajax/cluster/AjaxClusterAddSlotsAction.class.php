<?php
/**
 *
 * Filename: AjaxClusterAddSlotsAction.class.php
 *
 * @author liyan
 * @since 2017 9 15
 */
class AjaxClusterAddSlotsAction extends RCBaseAction {

    protected function rcExecute(Cluster $cluster) {
        $id = MRequest::post('id');
        $slots = MRequest::post('slots');

        $node = $cluster->node($id);
        if (is_null($node)) {
            return $this->displayJsonFail('node not exists');
        }

        $arrSlots = array_map(function($s) {
            return trim($s);
        }, explode(",", $slots));

        $slots = [];
        foreach ($arrSlots as $seg) {
            if (is_numeric($seg)) {
                $slots[] = $seg;
                continue;
            }
            list($from, $to) = array_pad(explode('-', $seg), 2, null);
            if (is_numeric($from) && is_numeric($to)) {
                $slots = array_merge($slots, range($from, $to));
                continue;
            }
            return $this->displayJsonFail('illegal slots ['.$seg.']');
        }
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
