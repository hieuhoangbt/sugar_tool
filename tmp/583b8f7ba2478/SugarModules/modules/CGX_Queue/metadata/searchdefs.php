<?php
$module_name = 'CGX_Queue';
$searchdefs [$module_name] =
    array(
        'layout' =>
            array(
                'basic_search' =>
                    array(
                        'name' =>
                            array(
                                'name' => 'name',
                                'default' => true,
                                'width' => '10%',
                            ),
                        'business_process_name' => array(
                            'name' => 'business_process_name',
                            'label' => 'Business Process',
                            'type' => 'multienum',
                        ),
                        'queue_name' => array(
                            'name' => 'queue_name',
                            'label' => 'Queues',
                            'type' => 'multienum',
                        ),
                    ),
                'advanced_search' =>
                    array(
                        'name' =>
                            array(
                                'name' => 'name',
                                'default' => true,
                                'width' => '10%',
                            ),
                        'business_process_name' => array(
                            'name' => 'business_process_name',
                            'label' => 'Business Process',
                            'type' => 'multienum',
                        ),
                        'queue_name' => array(
                            'name' => 'queue_name',
                            'label' => 'Queues',
                            'type' => 'multienum',
                        ),
                    ),
            ),
        'templateMeta' =>
            array(
                'maxColumns' => '3',
                'maxColumnsBasic' => '4',
                'widths' =>
                    array(
                        'label' => '10',
                        'field' => '30',
                    ),
            ),
    );
?>
