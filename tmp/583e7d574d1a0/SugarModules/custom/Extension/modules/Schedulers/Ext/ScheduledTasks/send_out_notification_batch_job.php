<?php

require_once('include/TimeDate.php');
/*
 * This function send out notification batch job
 */
$job_strings[] = 'sendOutNotificationBatchJob';
function sendOutNotificationBatchJob()
{
    $GLOBALS['log']->debug('------------------- Send out notification batch job started----------------------');
    $sla_notifications = getSLANotifications();
    foreach ($sla_notifications as $sla) {
        $sla_bean = new CGX_SLANotification();
        $sla_bean->retrieve($sla['id']);
        $email = $sla_bean->email_address;

        $contact = new Contact();
        $contact->retrieve($sla_bean->contact_id);

        $user = new User();
        $user->retrieve($sla_bean->user_id);

        $task = new Task();
        $task->retrieve($sla_bean->cgx_slanotification_taskstasks_ida);

        if (isContactRelatedToUser($contact, $sla_bean->user_id)) {
            if (empty($email)) {
                $email = $contact->emailAddress->getPrimaryAddress($contact);
            }
            $sla_bean->user_id = '';
        } else {
            if (empty($email)) {
                if (!empty($sla_bean->user_id)) {
                    $email = $user->emailAddress->getPrimaryAddress($user);
                }
                if (!empty($sla_bean->contact_id) && empty($email)) {
                    $email = $contact->emailAddress->getPrimaryAddress($contact);
                }
            }
        }
        if (!empty($email) && !empty($sla_bean->email_template_id)) {
            $bean_list = array($task, $user, $contact);
            $email_template = translateEmailTemplate($sla_bean->email_template_id, $bean_list);
            if (sendOutNotification(array($email), $email_template, $sla_bean)) {
                $sla_bean->email_sent_on = TimeDate::getInstance()->nowDb();
            }
        }
        $sla_bean->save();
    }
    $GLOBALS['log']->debug('------------------- Send out notification batch job completed----------------------');
}

/*
 * This function using get list SLA Notification to send email
 */

function getSLANotifications()
{
    $sla_notifications = array();
    $sql = "SELECT * FROM cgx_slanotification WHERE deleted=0 AND (email_sent_on IS NULL OR email_sent_on = '')";
    $rs = $GLOBALS['db']->query($sql);
    while ($row = $GLOBALS['db']->fetchByAssoc($rs)) {
        $sla_notifications[] = $row;
    }
    return $sla_notifications;
}

/*
 * This function using to send email
 */

function sendOutNotification($receiver_list, $email_template, $sla_bean)
{
    $GLOBALS['log']->info("SLA Notification: sendEmail called");
    require_once("include/SugarPHPMailer.php");
    $mailer = new SugarPHPMailer();

    $mailer->prepForOutbound();
    $mailer->setMailerForSystem();

    $emailSettings = getCustomPortalEmailSettings();
    $mailer->Subject = $email_template->subject;
    $mailer->Body = html_entity_decode($email_template->body_html);
    $mailer->IsHTML(true);
    $mailer->From = $emailSettings['from_address'];
    $mailer->FromName = $emailSettings['from_name'];
    foreach ($receiver_list as $email) {
        $mailer->AddAddress($email);
    }
    if ($mailer->Send()) {
        require_once('modules/Emails/Email.php');
        $emailObj = new Email();
        $emailObj->to_addrs = implode(",", $receiver_list);
        $emailObj->type = 'out';
        $emailObj->deleted = '0';
        $emailObj->name = $mailer->Subject;
        $emailObj->description_html = $mailer->Body;
        $emailObj->from_addr = $mailer->From;
        if ($sla_bean) {
            $emailObj->parent_type = "CGX_SLANotification";
            $emailObj->parent_id = $sla_bean->id;
        }
        $emailObj->date_sent = TimeDate::getInstance()->nowDb();
        $emailObj->modified_user_id = '1';
        $emailObj->created_by = '1';
        $emailObj->status = 'sent';
        $emailObj->save();
    } else {
        $GLOBALS['log']->fatal("SLA Notification: Could not send email:  " . $mailer->ErrorInfo);
        return false;
    }
    return true;
}

/*
 * This function check exist relationship between Contact and User
 */

function isContactRelatedToUser($contact, $user_id)
{
    if (isset($contact->field_defs['contacts_users_portal']) && !empty($contact->field_defs['contacts_users_portal'])) {
        if ($contact->contacts_users_portalusers_idb == $user_id) {
            return true;
        }
    }
    return false;
}

/*
 * This function using to translate email
 */

function translateEmailTemplate($template_id, $bean_list = array())
{
    require_once('modules/EmailTemplates/EmailTemplate.php');
    $template = new EmailTemplate();
    $template->retrieve($template_id);
    //Parse Subject If we used variable in subject, Parse Body HTML
    foreach ($bean_list as $bean) {
        $template->subject = $template->parse_template_bean($template->subject, $bean->module_dir, $bean);
        $template->body_html = $template->parse_template_bean($template->body_html, $bean->module_dir, $bean);
    }
    return $template;
}

/*
 * This function using to get Email Settings
 */
function getCustomPortalEmailSettings()
{
    global $sugar_config;
    $settings = array('from_name' => '', 'from_address' => '');

    if (array_key_exists("aop", $sugar_config)) {
        if (array_key_exists('support_from_address', $sugar_config['aop'])) {
            $settings['from_address'] = $sugar_config['aop']['support_from_address'];
        }
        if (array_key_exists('support_from_name', $sugar_config['aop'])) {
            $settings['from_name'] = $sugar_config['aop']['support_from_name'];
        }
    }
    if ($settings['from_name'] && $settings['from_address']) {
        return $settings;
    }

    //Fallback to sugar settings
    $admin = new Administration();
    $admin->retrieveSettings();
    if (!$settings['from_name']) {
        $settings['from_name'] = $admin->settings['notify_fromname'];
    }
    if (!$settings['from_address']) {
        $settings['from_address'] = $admin->settings['notify_fromaddress'];
    }
    return $settings;
}
