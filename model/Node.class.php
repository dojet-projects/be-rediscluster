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

    private function redis() {
        if (is_null($this->redis)) {
            $this->redis = DRedisIns::redis(['address' => $this->ip(), 'port' => $this->port()]);
        }
        return $this->redis;
    }

    public function isMyself() {
        $flags = $this->nodeArr['flags'];
        return in_array('myself', explode(',', $flags));
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

    public function slots() {
        $slots = $this->redis()->cluster_slots();
        return array_values(
            array_map(function($e) {
            return [$e[0], $e[1]];
            }, array_filter($slots, function($e) {
                list($from, $to, list($ip, $port)) = $e;
                return $ip == $this->ip() && $port == $this->port();
            }))
        );
    }

    public function redis_info() {
        return $this->redis()->info();
    }

}
