<?php
/**
 * add redis server
 *
 * Filename: AjaxServerAddAction.class.php
 *
 * @author liyan
 * @since 2017 9 11
 */
class AjaxServerAddAction extends RCBaseAction {

    protected function rcExecute(DRedisIns $redis) {
        $server = MRequest::post('server');
        $auth = MRequest::post('auth');

        list($address, $port) = explode(':', $server);
        $this->servers[] = ['server' => ['address' => $address, 'port' => $port], 'auth' => $auth];

        return $this->displayJsonSuccess();
    }

}
