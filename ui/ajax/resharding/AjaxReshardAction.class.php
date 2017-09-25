<?php
/**
 *
 * Filename: AjaxReshardAction.class.php
 *
 * @author liyan
 * @since 2017 9 25
 */
class AjaxReshardAction extends RCBaseAction {

    protected function rcExecute(Cluster $cluster) {
        $json = MRequest::post('plan');
        $plan = json_decode($json, true);
        if (false === $plan) {
            return $this->displayJsonFail();
        }

        foreach ($plan as $step) {
            $id = $step['id'];
            $slots = $step['slots'];
            $this->reshard($cluster, $id, $slots);
        }

        return $this->displayJsonSuccess();
    }

    protected function reshard(Cluster $cluster, $id, $slots) {
        foreach ($slots as $chunk) {
            $this->migrate($cluster, $id, $chunk);
        }
    }

    protected function migrate(Cluster $cluster, $id, $chunk) {
        $from = $chunk['from'];
        $to = $chunk['to'];

        for ($slot = $from; $slot <= $to; $slot++) {
            $source_node = $cluster->nodeBySlot($slot);
            if ($source_node instanceof Node) {
                // source node exists
                if ($source_node->id() == $id) {
                    // slot already in current node, skip migrating.
                    continue;
                }
                // migrate slot
                LibCluster::migrate_slot($slot, $source_node, $cluster->node($id));
            } else {
                // source node not exists, maybe this slot not assigned yet.
                $cluster->node($id)->addslots([$slot]);
            }
        }
    }

}
