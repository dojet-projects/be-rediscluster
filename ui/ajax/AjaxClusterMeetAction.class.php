<?php
/**
 *
 * Filename: AjaxClusterMeetAction.class.php
 *
 * @author liyan
 * @since 2017 9 13
 */
class AjaxClusterMeetAction extends RCBaseAction {

    protected function rcExecute(Cluster $cluster) {
        $server = MRequest::post('server');
        if (count($ip_port = explode(':', $server)) != 2) {
            return $this->displayJsonFail('Illegal server');
        }
        list($ip, $port) = $ip_port;

        $data = $cluster->meet($ip, $port);

        return $this->displayJsonSuccess($data);
    }

}
