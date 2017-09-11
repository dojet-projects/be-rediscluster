<?php
/**
 * Homepage
 *
 * Filename: HomeAction.class.php
 *
 * @author liyan
 * @since 2017 9 11
 */
abstract class RCBaseAction extends XBaseAction {

    protected $servers = [];
    private $conf_hash = null;

    final public function execute() {
        $conf_file = Config::runtimeConfigForKeyPath('global.conf');
        if (!file_exists($conf_file)) {
            mkdir(realpath($conf_file), true);
            touch($conf_file);
        }
        $json = file_get_contents($conf_file);
        $conf = json_decode($json, true);
        $conf_hash = $this->_conf_hash($conf);
        if (NULL === $conf) {
            $conf = [];
        }

        $this->servers = key_exists('servers', $conf) ? $conf['servers'] : [];

        $this->rcExecute($conf);

        $this->persistent_conf();
    }

    abstract protected function rcExecute($conf);

    private function _conf_hash($conf) {
        return md5(serialize($conf));
    }

    private function persistent_conf() {
        $conf = [
            'servers' => $this->servers,
        ];
        $hash = $this->_conf_hash($conf);
        if ($hash != $this->conf_hash) {
            $conf_file = Config::runtimeConfigForKeyPath('global.conf');
            file_put_contents($conf_file, json_encode($conf));
        }
    }

}
