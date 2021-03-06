<?php

/**
 * A simple description for this script
 *
 * PHP Version 5.2.0 or Upper version
 *
 * @package    Dura
 * @author     Hidehito NOZAWA aka Suin <http://suin.asia>
 * @copyright  2010 Hidehito NOZAWA
 * @license    http://www.gnu.org/licenses/gpl-3.0.html GNU GPL v3
 *
 */

class Dura_Controller_Default extends Dura_Abstract_Controller
{
	protected $error = null;
	protected $icons = array();

	protected $input = array();

	public $allowActions = array(
		Dura::DEFAULT_ACTION,
	);

	public function __construct()
	{
		parent::__construct();
		$this->icons = Dura_Class_Icon::getIcons();

		unset($this->icons['admin']);

		$this->_input();
	}

	function _main_before()
	{
		if (Dura::user()->isUser())
		{
			Dura::redirect('lounge');
		}
	}

	function _main_after()
	{
		if (Dura::$action != 'login')
		{
			$this->_main_action_login();
		}

		$this->_default();
	}

	function _main_action_login()
	{
		if (Dura::request('name') || Dura::request('submit'))
		{
			ob_start();

			try
			{
				$this->_login();
			}
			catch (Exception $e)
			{
				$this->error[] = $e->getMessage();
			}

			ob_end_clean();
		}
	}

	protected function _view()
	{
		Dura::$action = Dura::DEFAULT_ACTION;

		parent::_view();
	}

	function _input()
	{
		$this->input['name'] = Dura::request('name', null, true);
		$this->input['icon'] = Dura::request('icon', null, true);
		$this->input['language'] = Dura::request('language', null, true);

		$this->input['name'] = trim($this->input['name']);
		$this->input['icon'] = trim($this->input['icon']);
		$this->input['language'] = trim($this->input['language']);

		if ($this->input['language'])
		{
			Dura::setLang($this->input['language']);
		}
	}

	protected function _login()
	{
		$name = $this->input['name'];
		$icon = $this->input['icon'];
		$language = $this->input['language'];

		if ($name === '')
		{
			throw new Dura_Exception("Please input name.");
		}

		if (mb_strlen($name) > 10)
		{
			throw new Dura_Exception("Name should be less than 10 letters.");
		}

		$token = Dura::request('token');

		if (!Dura_Class_Ticket::check($token))
		{
			throw new Dura_Exception("Login error happened.");
		}

		if (empty($icon) || !isset($this->icons[$icon]))
		{
			throw new Dura_Exception("Please select a icon.");
		}

		$user = &Dura_Class_User::getInstance();
		$user->login($name, $icon, $language);

		Dura_Class_Ticket::destory();

		Dura::redirect('lounge');
	}

	protected function _default()
	{
		/*
		require_once DURA_TRUST_PATH . '/language/list.php';

		$languages = dura_get_language_list();

		foreach ($languages as $langcode => $name)
		{
			if (!file_exists(DURA_TRUST_PATH . '/language/' . $langcode . '.php'))
			{
				unset($languages[$langcode]);
			}
		}

		$acceptLangs = getenv('HTTP_ACCEPT_LANGUAGE');
		$acceptLangs = explode(',', $acceptLangs);
		$defaultLanguage = DURA_LANGUAGE;

		foreach ($acceptLangs as $k => $acceptLang)
		{
			@list($langcode, $dummy) = explode(';', $acceptLang);

			foreach ($languages as $language => $v)
			{
				if (stripos($language, $langcode) === 0)
				{
					$defaultLanguage = $language;
					break 2;
				}
			}
		}

		asort($languages);
		*/

		$lang = Dura_Model_Lang::getInstance();
		$languages = $lang->getList()->toArray();
		$defaultLanguage = $lang->acceptLang();

		$this->output['input'] = $this->input;

		$this->output['languages'] = $languages;
		$this->output['default_language'] = $this->input['language'] ? $this->input['language'] : $defaultLanguage;
		$this->output['icons'] = $this->icons;
		$this->output['error'] = $this->error;
		$this->output['token'] = Dura_Class_Ticket::issue();
		$this->_view();
	}
}
