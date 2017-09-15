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

    public function toArray() {
        return $this->nodeArr;
    }

    public function id() {
        return $this->nodeArr['id'];
    }

    public function ip() {
        list($ip, ) = explode(':', $this->nodeArr['ip:port']);
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

    public function forget($node_id) {
        return $this->redis()->cluster_forget($node_id);
    }

}
