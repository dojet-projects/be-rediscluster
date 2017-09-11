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

    protected function rcExecute($conf) {
        $server = MRequest::post('server');
        $auth = MRequest::post('auth');

        $this->servers[] = ['server' => $server, 'auth' => $auth];

        return $this->displayJsonSuccess();
    }

}
