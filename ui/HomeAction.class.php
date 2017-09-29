<?php
/**
 * Homepage
 *
 * Filename: HomeAction.class.php
 *
 * @author liyan
 * @since 2017 9 11
 */
class HomeAction extends XBaseAction {

    public function execute() {
        $ipport = MRequest::post('ipport');
        if (empty($ipport)) {
            return $this->displayTemplate('home/entry.tpl.php');
        }

        list($ip, $port) = array_pad(explode(':', $ipport), 2, null);
        if (!filter_var($ip, FILTER_VALIDATE_IP)) {
            return $this->displayTemplate('home/entry.tpl.php');
        }

        if (!filter_var($port, FILTER_VALIDATE_INT) || $port < 0 || $port > 65535) {
            return $this->displayTemplate('home/entry.tpl.php');
        }

        MCookie::setCookie('cip', $ip);
        MCookie::setCookie('cport', $port);

        redirect('/nodelist');
    }

}
