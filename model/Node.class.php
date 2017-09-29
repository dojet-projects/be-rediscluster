<?php
/**
 *
 * Filename: Node.class.php
 *
 * @author liyan
 * @since 2017 9 14
 */
class Node {

    private $nodeArr = [];
    private $redis;

    function __construct($str_node) {
        $node = explode(' ', $str_node);
        $this->nodeArr = [
            'id' => array_shift($node),
            'ip:port' => array_shift($node),
            'flags' => array_shift($node),
            'master' => array_shift($node),
            'ping-sent' => array_shift($node),
            'pong-recv' => array_shift($node),
            'config-epoch' => array_shift($node),
            'link-state' => array_shift($node),
            'slots' => join(' ', $node),
        ];
    }

    public static function node($str_node) {
        return new Node($str_node);
    }

    public static function nodeById($id, DRedisIns $redis) {
        $cluster = Cluster::fromRedis($redis);
        return $cluster->node($id);
    }

    public function isMyself() {
        $flags = $this->nodeArr['flags'];
        return in_array('myself', explode(',', $flags));
    }

    public function isMaster() {
        $flags = $this->nodeArr['flags'];
        return in_array('master', explode(',', $flags));
    }

    public function isSlave() {
        $flags = $this->nodeArr['flags'];
        return in_array('slave', explode(',', $flags));
    }

    public function toArray() {
        return $this->nodeArr;
    }

    public function id() {
        return $this->nodeArr['id'];
    }

    public function ip() {
        list($ip, ) = explode(':', $this->nodeArr['ip:port']);
        if (empty($ip)) {
            $ip = '127.0.0.1';
        }
        return $ip;
    }

    public function port() {
        list(, $port) = explode(':', $this->nodeArr['ip:port']);
        return $port;
    }

    public function redis() {
        if (is_null($this->redis)) {
            $this->redis = DRedisIns::redis(['address' => $this->ip(), 'port' => $this->port()]);
        }
        return $this->redis;
    }

    public function sameWith(Node $node) {
        $nodeArr = $node->toArray();
        if ($nodeArr['id'] !== $this->nodeArr['id']) {
            return false;
        }
        if ($nodeArr['ip:port'] !== $this->nodeArr['ip:port']) {
            return false;
        }
        if ($nodeArr['slots'] !== $this->nodeArr['slots']) {
            return false;
        }

        return true;
    }

    public function cluster() {
        return Cluster::fromRedis($this->redis());
    }

    public function meet($ip, $port) {
        return $this->redis()->cluster_meet($ip, $port);
    }

    public function forget($node_id) {
        return $this->redis()->cluster_forget($node_id);
    }

    public function addslots($slots) {
        return $this->redis()->cluster_addslots($slots);
    }

    public function delslots($slots) {
        return $this->redis()->cluster_delslots($slots);
    }

    public function cluster_slots() {
        return $this->redis()->cluster_slots();
    }

    public function cluster_keyslot($key) {
        return $this->redis()->cluster_keyslot($key);
    }

    public function cluster_info() {
        $str = $this->redis()->cluster_info();
        return
            array_reduce(
                array_map(function($e) {
                    return array_pad(explode(":", trim($e)), 2, null);
                }, explode("\n", trim($str))),
                function($reduce, $e) {
                    $reduce[$e[0]] = $e[1];
                    return $reduce;
                }, []
            );
    }

    public function cluster_nodes() {
        return $this->redis()->cluster_nodes();
    }

    public function slots() {
        $slots = $this->cluster_slots();
        return array_values(
            array_map(function($e) {
                return [$e[0], $e[1]];
            }, array_filter($slots, function($e) {
                list($from, $to, list($ip, $port)) = $e;
                return $ip == $this->ip() && $port == $this->port();
            }))
        );
    }

    public function setslot_importing($slot, $source_node_id) {
        return $this->redis()->cluster_setslot($slot, 'IMPORTING', $source_node_id);
    }

    public function setslot_migrating($slot, $destination_node_id) {
        return $this->redis()->cluster_setslot($slot, 'MIGRATING', $destination_node_id);
    }

    public function setslot_node($slot, $node_id) {
        return $this->redis()->cluster_setslot($slot, 'NODE', $node_id);
    }

    public function setslot_stable($slot) {
        return $this->redis()->cluster_setslot($slot, 'STABLE');
    }

    public function count_keys_in_slot($slot) {
        return $this->redis()->cluster_countkeysinslot($slot);
    }

    public function get_keys_in_slot($slot, $count) {
        return $this->redis()->cluster_getkeysinslot($slot, $count);
    }

    public function redis_info() {
        $str = $this->redis()->info();
        $arrLines = array_filter(array_map(function($line) {
            return trim($line);
        }, explode("\r", $str)), function($line) {
            return !empty($line);
        });

        $info = [];
        foreach ($arrLines as $line) {
            if (strpos($line, "# ") === 0) {
                $i = &$info[substr($line, 2)];
                continue;
            }
            $p = strpos($line, ":");
            $i[substr($line, 0, $p)] = substr($line, $p + 1);
        }
        unset($i);
        return $info;
    }

    public function migrate($host, $port, $key, $destination_db, $timeout) {
        return $this->redis()->migrate($host, $port, $key, $destination_db, $timeout);
    }

    public function reset($type) {
        return $this->redis()->cluster_reset($type);
    }

    public function replicate(Node $master_node) {
        $master_node_id = $master_node->id();
        return $this->redis()->replicate($master_node_id);
    }

}
