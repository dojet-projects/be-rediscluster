<?php
/**
 * Homepage
 *
 * Filename: HomeAction.class.php
 *
 * @author liyan
 * @since 2017 9 11
 */
class HomeAction extends RCBaseAction {

    protected function rcExecute(Cluster $cluster) {
        $this->pageExecute();
    }

    protected function redis_error(Exception $e) {
        $this->pageExecute();
    }

    protected function pageExecute() {
        $this->displayTemplate('home/home.tpl.php');
    }

}
