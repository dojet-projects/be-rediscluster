<?php
/**
 *
 * Filename: Cluster.class.php
 *
 * @author liyan
 * @since 2017 9 14
 */
class Cluster {

    private $nodes;

    private $slots;

    function __construct($nodes) {
        DAssert::assertArray($nodes);
        foreach ($nodes as $node) {
            DAssert::assert($node instanceof Node, 'illegal node object');
        }
        $this->nodes = $nodes;
    }

    public static function fromStrNodes($str_nodes) {
        $arr_str_nodes = array_filter(explode("\n", $str_nodes));
        $nodes = array_map(function($str_node) {
            return Node::node($str_node);
        }, $arr_str_nodes);
        return new Cluster($nodes);
    }

    public static function fromRedis(DRedisIns $redis) {
        $str_nodes = $redis->cluster_nodes();
        return Cluster::fromStrNodes($str_nodes);
    }

    public function nodes() {
        return $this->nodes;
    }

    public function nodeCount() {
        return count($this->nodes());
    }

    public function masterNodes() {
        return array_filter($this->nodes(), function($node) {
            return $node->isMaster();
        });
    }

    public function node($id) {
        foreach ($this->nodes() as $node) {
            if ($node->id() == $id) {
                return $node;
            }
        }
        return null;
    }

    public function nodeByIpPort($ip, $port) {
        foreach ($this->nodes() as $node) {
            if ($node->ip() == $ip && $node->port() == $port) {
                return $node;
            }
        }
        return null;
    }

    public function nodeBySlot($slot) {
        $slots = $this->slots();
        foreach ($slots as $nodeslot) {
            list($from, $to, list($ip, $port)) = $nodeslot;
            if ($from <= $slot && $slot <= $to) {
                return $this->nodeByIpPort($ip, $port);
            }
        }
        return null;
    }

    public function anynode() {
        return $this->nodes[array_rand($this->nodes)];
    }

    public function meet($ip, $port) {
        $node = $this->anynode();
        return $node->meet($ip, $port);
    }

    public function myself() {
        foreach ($this->nodes() as $node) {
            if ($node->isMyself()) {
                return $node;
            }
        }
        return null;
    }

    public function set($key, $value) {
        $slot = $this->myself()->cluster_keyslot($key);
        $node = $this->nodeBySlot($slot);
        return $node->redis()->set($key, $value);
    }

    public function slots() {
        if (is_null($this->slots)) {
            $myself = $this->myself();
            DAssert::assertNotNull($myself);
            $this->slots = $myself->cluster_slots();
        }
        return $this->slots;
    }

    public function delslots($slots) {
        foreach ($this->nodes() as $node) {
            try {
                $node->delslots($slots);
            } catch (Exception $e) {
                return false;
            }
        }
        return true;
    }

    public function toArray() {
        $array = [];
        foreach ($this->nodes as $node) {
            $array[] = $node->toArray();
        }
        return $array;
    }

}
