<?php 
/*
 * Copyright 2010 Sean Proctor
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

if(!defined('IN_PHPC')) {
       die("Hacking attempt");
}

function password_submit()
{
	global $phpcid, $vars, $phpcdb;

        if(!is_user()) {
                return tag('div', _('You must be logged in.'));
        }

	if(empty($vars['phpc_token'])
			|| $vars['phpc_token'] != $_SESSION['phpc_token']) {
		return tag('div', _('Secret token mismatch. Possible request forgery attempt.'));
	}

	$uid = $_SESSION['phpc_uid'];
	$user = $phpcdb->get_user($uid);

	if(!$user)
		soft_error(_('Invalid user.'));

	if(!$user->is_password_editable())
		soft_error(_('You do not have permission to change your password.'));

        if(!isset($vars['old_password'])) {
                return tag('div', _('You must specify your old password.'));
        } else {
		$old_password = $vars['old_password'];
	}

	if($user->password != md5($old_password)) {
                return tag('div', _('The password you entered did not match your old password.'));
	}

        if(empty($vars['password1'])) {
                return tag('div', _('You must specify a password'));
        }

        if(empty($vars['password2'])
                || $vars['password1'] != $vars['password2']) {
                return tag('div', _('Your passwords did not match'));
        }

        $passwd = md5($vars['password1']);

	$phpcdb->set_password($uid, $passwd);

        return tag('div', _('Password updated.'));
}

?>
