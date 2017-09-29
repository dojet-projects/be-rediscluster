<?php
/**
 *
 * Filename: AjaxReshardPlanAction.class.php
 *
 * @author liyan
 * @since 2017 9 22
 */
class AjaxReshardPlanAction extends RCBaseAction {

    protected function rcExecute(Cluster $cluster) {
        $nodes = $cluster->masterNodes();
        $secs = ((1 << 14) / count($nodes));
        $plan = [];
        foreach (array_values($nodes) as $key => $node) {
            $plan[] = [
                'id' => $node->id(),
                'slots' => [
                    [
                        'from' => round($key * $secs),
                        'to' => round(($key + 1) * $secs) - 1,
                    ],
                ],
            ];
        }
        return $this->displayJsonSuccess($plan);
    }

}
