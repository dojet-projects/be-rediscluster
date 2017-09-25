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
        $slot = MRequest::post('slot');
        $source_node_id = MRequest::post('source_node_id');
        $destination_node_id = MRequest::post('destination_node_id');

        try {
            $source_node = $cluster->node($source_node_id);
            $destination_node = $cluster->node($destination_node_id);

            LibCluster::migrate_slot($slot, $source_node, $destination_node);

        } catch (DRedisException $e) {
            if ($e->getCode() == DRedisException::REPLY_ERROR) {
                return $this->displayJsonFail(null, $e->getMessage());
            }
        }

        return $this->displayJsonSuccess();
    }

}
