<?php
/**
 * Filename: StartAction.class.php
 *
 * @author liyan
 * @since 2017 9 28
 */
class StartAction extends XBaseAction {

    public function execute() {
        $this->displayTemplate('home/entry.tpl.php');
    }

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
