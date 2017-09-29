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
                'used_memory' => $redis_info['Memory']['used_memory_human'],
                'used_memory_peak' => $redis_info['Memory']['used_memory_peak_human'],
                'mem_fragmentation_ratio' => $redis_info['Memory']['mem_fragmentation_ratio'],
                'keyspace' => $redis_info['Keyspace'],
                'slots' => $slots,
            ];
        }
        return $this->displayJsonSuccess(['info' => $info]);
    }

}
