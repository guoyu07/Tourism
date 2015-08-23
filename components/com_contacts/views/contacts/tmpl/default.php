<?php

/**
 * @version     1.0.0
 * @package     com_contacts
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Farid <faridv@gmail.com> - http://www.faridr.ir
 */
// no direct access
defined('_JEXEC') or die;
header('Content-type: text/plain; charset=utf-8');
JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
JSession::checkToken() or die('Invalid Token');
$messages = array(
	'empty' => 'error:از وارد شدن تمام موارد اطمینان حاصل کنید'
	, 'error' => 'error:خطایی پیش آمده، لطفاً مجدداً تلاش کنید'
	, 'done' => 'success:پیام شما با موفقیت ثبت شد'
);
$app = JFactory::getApplication();
$user = JFactory::getUser();
$db = JFactory::getDbo();
$userId = $user->get('id');
if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
	$ip = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
	$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
	$ip = $_SERVER['REMOTE_ADDR'];
}
$input = $app->input;
$cols = array('name', 'email', 'message', 'ip', 'created', 'published');
$d = array(
	'name' => $db->quote($input->getString('name', ''))
	, 'email' => $db->quote(filter_var($input->getString('email', ''), FILTER_VALIDATE_EMAIL))
	, 'message' => $db->quote($input->getString('message', ''))
	, 'ip' => $db->quote($ip)
	, 'date' => $db->quote(date('Y-m-d H:i:s', time()))
	, 'published' => $db->quote('0')
);

foreach ($d as $key => $value) {
	$value = trim($value);
	if (empty($value) && $value !== '0') {
		die($messages['empty']);
	}
}

$query = $db->getQuery(true);
$query->insert($db->quoteName('#__contacts'))
		->columns($db->quoteName($cols))
		->values(implode(',', $d));

$db->setQuery($query);
$state = $db->execute();
echo ($state === true) ? $messages['done'] : $messages['error'];

$app->close();
