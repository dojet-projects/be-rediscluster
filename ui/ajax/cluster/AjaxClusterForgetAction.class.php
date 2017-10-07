<?php
/**
 *
 * Filename: AjaxClusterForgetAction.class.php
 *
 * @author liyan
 * @since 2017 9 14
 */
class AjaxClusterForgetAction extends RCBaseAction {

    protected function rcExecute(Cluster $cluster) {
        $id = MRequest::post('id');
        $thisnode = $cluster->node($id);

        foreach ($thisnode->cluster()->nodes() as $node) {
            if ($node->isMyself()) {
                continue;
            }
            $node->forget($thisnode);
            $thisnode->forget($node);
        }
        return $this->displayJsonSuccess();
    }

}
