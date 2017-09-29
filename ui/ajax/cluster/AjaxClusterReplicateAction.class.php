<?php
/**
 *
 * Filename: AjaxClusterReplicateAction.class.php
 *
 * @author liyan
 * @since 2017 9 27
 */
class AjaxClusterReplicateAction extends RCBaseAction {

    protected function rcExecute(Cluster $cluster) {
        $node_id = MRequest::post('node_id');
        $master_node_id = MRequest::post('master_node_id');

        $node = $cluster->node($node_id);
        $master = $cluster->node($master_node_id);

        try {
            $node->replicate($master);
        } catch (Exception $e) {
            return $this->displayJsonFail(null, $e->getMessage());
        }

        return $this->displayJsonSuccess();
    }

}
