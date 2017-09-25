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

        foreach ($cluster->nodes() as $node) {
            if ($node->id() == $id) {
                continue;
            }
            $node->forget($id);
        }
        return $this->displayJsonSuccess();
    }

}
