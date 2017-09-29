<?php
/**
 *
 * Filename: AjaxNodeInfoAction.class.php
 *
 * @author liyan
 * @since 2017 9 29
 */
class AjaxNodeInfoAction extends RCBaseAction {

    protected function rcExecute(Cluster $cluster) {
        $ids = MRequest::post('ids');
        $arrNodeIDs = explode(',', $ids);
        $info = [];
        foreach ($arrNodeIDs as $id) {
            $node = $cluster->node($id);
            $redis_info = $node->redis_info();
            $slots = $node->slots();
            $info[$id] = [
                'redis_info' => $redis_info,
                'slots' => $slots,
            ];
        }
        return $this->displayJsonSuccess(['info' => $info]);
    }

}
