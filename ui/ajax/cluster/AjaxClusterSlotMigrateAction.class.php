<?php
/**
 *
 * Filename: AjaxClusterSlotMigrateAction.class.php
 *
 * @author liyan
 * @since 2017 9 21
 */
class AjaxClusterSlotMigrateAction extends RCBaseAction {

    protected function rcExecute(Cluster $cluster) {
        $slots = MRequest::post('slots');
        $source_node_id = MRequest::post('source_node_id');
        $destination_node_id = MRequest::post('destination_node_id');

        $data = ['migrated' => []];
        try {
            $source_node = $cluster->node($source_node_id);
            $destination_node = $cluster->node($destination_node_id);
            foreach ($slots as $slot) {
                LibCluster::migrate_slot($slot, $source_node, $destination_node);
                $data['migrated'][] = $slot;
            }

        } catch (Exception $e) {
            // if ($e->getCode() == DRedisException::REPLY_ERROR) {
                return $this->displayJsonFail($data, $e->getMessage());
            // }
        }

        return $this->displayJsonSuccess($data);
    }

}
