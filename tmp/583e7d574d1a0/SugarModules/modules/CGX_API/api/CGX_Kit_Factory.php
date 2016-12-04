<?php
require_once(__DIR__ . '/Kit/CGX_Kit_Workflow.php');
require_once(__DIR__ . '/Kit/CGX_Kit_Queues.php');
require_once(__DIR__ . '/Kit/CGX_Kit_Tasks.php');
require_once(__DIR__ . '/Kit/CGX_Kit_Users.php');
require_once(__DIR__ . '/Kit/CGX_Kit_Roles.php');

/**
 * CGX Kit factory
 */
class CGX_Kit_Factory
{
    /**
     * create new resource
     * @param type $resource
     * @return \CGX_Kit
     */
    public static function create($resource)
    {
        $kit = null;
        switch ($resource) {
            case 'workflow':
                $kit = new CGX_Kit_Workflow();
                break;
            case 'queues':
                $kit = new CGX_Kit_Queues();
                break;
            case 'tasks':
                $kit = new CGX_Kit_Tasks();
                break;
            case 'users':
                $kit = new CGX_Kit_Users();
                break;
            case 'roles':
                $kit = new CGX_Kit_Roles();
                break;
        }

        return $kit;
    }
}
