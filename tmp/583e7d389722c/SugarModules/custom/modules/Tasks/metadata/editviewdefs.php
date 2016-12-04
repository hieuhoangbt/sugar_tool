<?php
$viewdefs ['Tasks'] =
array(
  'EditView' =>
  array(
    'templateMeta' =>
    array(
      'form' =>
      array(
        'hidden' =>
        array(
          0 => '<input type="hidden" name="isSaveAndNew" value="false">',
          1 => '<input type="hidden" name="cgx_check" value="{if $fields.activity_id_c.value}1{else}0{/if}">',
          2 => '<input type="hidden" name="old_name" value="{$fields.name.value}">',
          3 => '<input type="hidden" name="old_status" value="{$fields.status.value}">',
          4 => '<input type="hidden" name="old_parent_type" value="{$fields.parent_type.value}">',
          5 => '<input type="hidden" name="old_parent_id" value="{$fields.parent_id.value}">',
        ),
        'buttons' =>
        array(
          0 => 'SAVE',
          1 => 'CANCEL',
          2 =>
          array(
            'customCode' => '{if $fields.status.value != "completed" && !$fields.activity_id_c.value}<input title="{$APP.LBL_CLOSE_AND_CREATE_BUTTON_TITLE}" class="button" onclick="document.getElementById(\'status\').value=\'completed\'; this.form.action.value=\'Save\'; this.form.return_module.value=\'Tasks\'; this.form.isDuplicate.value=true; this.form.isSaveAndNew.value=true; this.form.return_action.value=\'EditView\'; this.form.return_id.value=\'{$fields.id.value}\'; if(check_form(\'EditView\'))SUGAR.ajaxUI.submitForm(this.form);" type="button" name="button" value="{$APP.LBL_CLOSE_AND_CREATE_BUTTON_LABEL}">{/if}',
          ),
        ),
      ),
      'includes' => 
      array (
        0 => 
        array (
          'file' => 'custom/modules/Tasks/js/CGX_Connector_Editview.js',
        ),
      ),
      'maxColumns' => '2',
      'widths' =>
      array(
        0 =>
        array(
          'label' => '10',
          'field' => '30',
        ),
        1 =>
        array(
          'label' => '10',
          'field' => '30',
        ),
      ),
      'useTabs' => false,
      'tabDefs' =>
      array(
        'LBL_TASK_INFORMATION' =>
        array(
          'newTab' => false,
          'panelDefault' => 'expanded',
        ),
        'LBL_PANEL_ASSIGNMENT' =>
        array(
          'newTab' => false,
          'panelDefault' => 'expanded',
        ),
        'LBL_EDITVIEW_PANEL1' =>
        array(
          'newTab' => false,
          'panelDefault' => 'expanded',
        ),
      ),
    ),
    'panels' =>
    array(
      'lbl_task_information' =>
      array(
        0 =>
        array(
          0 =>
          array(
            'name' => 'name',
            'displayParams' =>
            array(
              'required' => true,
            ),
          ),
          1 =>
          array(
            'name' => 'status',
            'displayParams' =>
            array(
              'required' => true,
            ),
          ),
        ),
        1 =>
        array(
          0 =>
          array(
            'name' => 'date_start',
            'type' => 'datetimecombo',
            'displayParams' =>
            array(
              'showNoneCheckbox' => true,
              'showFormats' => true,
            ),
          ),
          1 =>
          array(
            'name' => 'parent_name',
            'label' => 'LBL_LIST_RELATED_TO',
          ),
        ),
        2 =>
        array(
          0 =>
          array(
            'name' => 'date_due',
            'type' => 'datetimecombo',
            'displayParams' =>
            array(
              'showNoneCheckbox' => true,
              'showFormats' => true,
            ),
          ),
          1 =>
          array(
            'name' => 'contact_name',
            'label' => 'LBL_CONTACT_NAME',
          ),
        ),
        3 =>
        array(
          0 =>
          array(
            'name' => 'priority',
            'displayParams' =>
            array(
              'required' => true,
            ),
          ),
        ),
        4 =>
        array(
          0 =>
          array(
            'name' => 'description',
          ),
        ),
      ),
      'LBL_PANEL_ASSIGNMENT' =>
      array(
        0 =>
        array(
          0 => 'assigned_user_name',
        ),
      ),       
    ),
  ),
);
