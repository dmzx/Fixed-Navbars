<?php
/**
*
* @package phpBB Extension - Fixed Navbars
* @copyright (c) 2014 dmzx - http://www.dmzx-web.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace dmzx\fixednavbars\migrations;

class fixednavbars_schema extends \phpbb\db\migration\migration
{
	public function update_schema()
	{
		return array(
			'add_columns'	=> array(
				$this->table_prefix . 'users'	=> array(
					'user_fixedheader'			=> array('BOOL', 1),
					'user_headerbreadcrumb'		=> array('BOOL', 0),
					'user_fixedfooter'			=> array('BOOL', 1),
				),
			),
		);
	}

	public function revert_schema()
	{
		return array(
			'drop_columns'	=> array(
				$this->table_prefix . 'users'	=> array(
					'user_fixedheader',
					'user_headerbreadcrumb',
					'user_fixedfooter',
				),
			),
		);
	}
}
