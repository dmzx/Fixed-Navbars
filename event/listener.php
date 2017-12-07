<?php
/**
*
* @package phpBB Extension - Fixed Navbars
* @copyright (c) 2014 dmzx - http://www.dmzx-web.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace dmzx\fixednavbars\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use phpbb\request\request_interface;
use phpbb\template\template;
use phpbb\user;

class listener implements EventSubscriberInterface
{
	/** @var request_interface  */
	protected $request;
	
	/* @var template */
	protected $template;

	/* @var user */
	protected $user;

	/**
	* Constructor
	*
	* @param request_interface	    $request
	* @param template    			$template
	* @param user                   $user
	*/
	public function __construct(
		request_interface $request, 
		template $template, 
		user $user
	)
	{
		$this->request  = $request;
		$this->template = $template;
		$this->user     = $user;
	}

	static public function getSubscribedEvents()
	{
		return array(
			'core.page_header'                => 'page_header',
			'core.ucp_prefs_view_data'        => 'ucp_prefs_view_data',
			'core.ucp_prefs_view_update_data' => 'ucp_prefs_view_update_data',
		);
	}

	public function page_header($event)
	{
		$this->template->assign_vars(array(
			'S_FIXEDHEADER'      =>	!empty($this->user->data['user_fixedheader']) ? true : false,
			'S_HEADERBREADCRUMB' =>	!empty($this->user->data['user_headerbreadcrumb']) ? true : false,
			'S_FIXEDFOOTER'      =>	!empty($this->user->data['user_fixedfooter']) ? true : false,
		));
	}
	
	public function ucp_prefs_view_data($event)
	{
		$this->user->add_lang_ext('dmzx/fixednavbars', 'fixednavbars_ucp');
		
		$event['data'] = array_merge($event['data'], array(
			'fixedheader'      => $this->request->variable('fixedheader', (int) $this->user->data['user_fixedheader']),
			'headerbreadcrumb' => $this->request->variable('headerbreadcrumb', (int) $this->user->data['user_headerbreadcrumb']),
			'fixedfooter'      => $this->request->variable('fixedfooter', (int) $this->user->data['user_fixedfooter']),
		));

		if (!$event['submit'])
		{
			$this->template->assign_vars(array(
				'S_UCP_FIXEDHEADER'      => $event['data']['fixedheader'],
				'S_UCP_HEADERBREADCRUMB' => $event['data']['headerbreadcrumb'],
				'S_UCP_FIXEDFOOTER'      => $event['data']['fixedfooter'],
			));
		}
	}

	public function ucp_prefs_view_update_data($event)
	{
		$event['sql_ary'] = array_merge($event['sql_ary'], array(
			'user_fixedheader'      => $event['data']['fixedheader'],
			'user_headerbreadcrumb' => $event['data']['headerbreadcrumb'],
			'user_fixedfooter'      => $event['data']['fixedfooter'],
		));
	}
}
