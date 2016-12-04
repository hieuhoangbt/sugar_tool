<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

class CGX_QueueViewList extends ViewList {
    /**
     * Pre display data
     * Add js/css
     */
    public function preDisplay() {
        echo '<script type="text/javascript">document.getElementById("create_link").remove();</script>';
        parent::preDisplay();
    }

    /**
     * @override : listViewProcess
     *
     * @return :
     */
    public function listViewProcess() {
        global $current_user;
        $this->params['custom_where'] = ' AND cgx_queue.assigned_user_id = "' . $current_user->id .'"';
        $this->lv->multiSelect = false; //This removes Check Box
        $this->lv->quickViewLinks = false; //This removes Edit Link
        parent::listViewProcess();
    }

}
