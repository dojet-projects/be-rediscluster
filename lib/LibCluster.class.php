<?php
/**
 *
 * Filename: LibCluster.class.php
 *
 * @author liyan
 * @since 2017 9 21
 */
class LibCluster {

    public static function migrate_slot($slot, Node $source_node, Node $destination_node) {
        $source_node_id = $source_node->id();
        $destination_node_id = $destination_node->id();

        $destination_node->setslot_importing($slot, $source_node_id);
        $source_node->setslot_migrating($slot, $destination_node_id);

        $sum = $source_node->count_keys_in_slot($slot);
        $count = 1000;
        $dest_host = $destination_node->ip();
        $dest_port = $destination_node->port();
        for ($i = 0; $i < $sum; $i+= $count) {
            $keys = $source_node->get_keys_in_slot($slot, $count);
            foreach ($keys as $key) {
                $source_node->migrate($dest_host, $dest_port, $key, 0, 1000);
            }
        }

        $destination_node->setslot_node($slot, $destination_node_id);
        $source_node->setslot_node($slot, $destination_node_id);
    }

    public static function parseSlots($arrSlotSegs) {
        $segs = array_map(function($s) {
            return trim($s);
        }, $arrSlotSegs);

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
    }

}
