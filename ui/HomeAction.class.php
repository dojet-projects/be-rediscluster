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

    protected function rcExecute($conf) {
        $this->assign('servers', $this->servers);
        $this->displayTemplate('home/home.tpl.php');
    }

}
