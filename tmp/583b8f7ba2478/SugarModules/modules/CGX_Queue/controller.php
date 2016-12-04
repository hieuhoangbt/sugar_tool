<?php
/**
 * Queue controller
 */
class CGX_QueueController extends SugarController {
    /**
     * Actually remap the action if required.
     *
     */
    protected function remapAction(){
        if($this->action == 'EditView' || $this->action == 'DetailView' || $this->action == 'QuickCreate' ){
            SugarApplication::redirect('/index.php?module=CGX_Queue');
        }
        parent::remapAction();
    }
}
