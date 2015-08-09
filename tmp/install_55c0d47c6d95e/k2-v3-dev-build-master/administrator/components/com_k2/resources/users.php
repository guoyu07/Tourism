<?php
/**
 * @version		3.0.0
 * @package		K2
 * @author		JoomlaWorks http://www.joomlaworks.net
 * @copyright	Copyright (c) 2006 - 2014 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die ;

require_once JPATH_ADMINISTRATOR.'/components/com_k2/resources/resource.php';
require_once JPATH_SITE.'/components/com_k2/helpers/route.php';
require_once JPATH_ADMINISTRATOR.'/components/com_k2/helpers/images.php';

/**
 * K2 user resource class.
 */

class K2Users extends K2Resource
{

	/**
	 * @var array	Items instances container.
	 */
	protected static $instances = array();

	/**
	 * Constructor.
	 *
	 * @param object $data
	 *
	 * @return void
	 */

	public function __construct($data)
	{
		parent::__construct($data);
		self::$instances[$this->id] = $this;
	}

	/**
	 * Gets an item instance.
	 *
	 * @param integer $id	The id of the item to get.
	 *
	 * @return K2Tag The tag object.
	 */
	public static function getInstance($id)
	{
		if (empty(self::$instances[$id]))
		{
			K2Model::addIncludePath(JPATH_ADMINISTRATOR.'/components/com_k2/models');
			$model = K2Model::getInstance('Users');
			$model->setState('id', $id);
			$item = $model->getRow();
			self::$instances[$id] = $item;
		}
		return self::$instances[$id];
	}

	/**
	 * Prepares the row for output
	 *
	 * @param string $mode	The mode for preparing data. 'site' for fron-end data, 'admin' for administrator operations.
	 *
	 * @return void
	 */
	public function prepare($mode = null)
	{
		// Prepare generic properties like dates and authors
		parent::prepare($mode);

		if ($this->id)
		{
			// Prepare specific properties
			$this->editLink = JURI::base(true).'/index.php?option=com_k2#users/edit/'.$this->id;

			$this->enabled = (int)!$this->block;
			$this->activated = (int)!$this->activation;
			$this->groupsValue = isset($this->groups) ? implode(', ', $this->groups) : '';
			$this->canAdd = JFactory::getUser($this->id)->authorise('k2.item.create', 'com_k2');
			$this->addLink = JURI::base(true).'/index.php?option=com_k2#items/add';

			// Image
			$this->image = $this->getImage();

			// Unset password
			$this->password = '';
		}

	}

	public function getLink()
	{
		if (!isset($this->link))
		{
			if (JFactory::getConfig()->get('unicodeslugs') == 1)
			{
				$this->alias = JFilterOutput::stringURLUnicodeSlug($this->name);
			}
			else
			{
				$this->alias = JFilterOutput::stringURLSafe($this->name);
			}
			$this->link = JRoute::_(K2HelperRoute::getUserRoute($this->id.':'.$this->alias));
		}
		return $this->link;
	}

	public function getFeedLink()
	{
		if (!isset($this->feedLink))
		{
			if (JFactory::getConfig()->get('unicodeslugs') == 1)
			{
				$this->alias = JFilterOutput::stringURLUnicodeSlug($this->name);
			}
			else
			{
				$this->alias = JFilterOutput::stringURLSafe($this->name);
			}
			$this->feedLink = JRoute::_(K2HelperRoute::getUserRoute($this->id.':'.$this->alias).'&format=feed');
		}
		return $this->feedLink;
	}

	public function getUrl()
	{
		if (!isset($this->url))
		{
			if (JFactory::getConfig()->get('unicodeslugs') == 1)
			{
				$this->alias = JFilterOutput::stringURLUnicodeSlug($this->name);
			}
			else
			{
				$this->alias = JFilterOutput::stringURLSafe($this->name);
			}
			$this->url = JRoute::_(K2HelperRoute::getUserRoute($this->id.':'.$this->alias), true, -1);
		}
		return $this->url;
	}

	public function getImage()
	{
		return K2HelperImages::getUserImage($this);
	}

	public function getNumOfComments()
	{
		K2Model::addIncludePath(JPATH_ADMINISTRATOR.'/components/com_k2/models');
		$model = K2Model::getInstance('Comments');
		$model->setState('userId', $this->id);
		$model->setState('state', 1);
		$numOfComments = $model->countRows();
		return $numOfComments;
	}

	public function getExtraFields()
	{
		$extraFields = new stdClass;
		foreach ($this->extraFieldsGroups as $extraFieldsGroup)
		{
			foreach ($extraFieldsGroup->fields as $extraField)
			{
				$field = clone($extraField);
				$field->value = $extraField->output;
				$property = $field->alias;
				$extraFields->$property = $field;
			}
		}
		return $extraFields;
	}

	public function getExtraFieldsGroups()
	{
		$groups = array();
		if ($this->id)
		{
			$user = JFactory::getUser($this->id);
			$usergroups = $user->getAuthorisedGroups();
			$groups = K2HelperExtraFields::getUserExtraFieldsGroups($this->extra_fields);
		}
		return $groups;
	}

	public function getEvents()
	{
		$events = new stdClass;
		$dispatcher = JDispatcher::getInstance();
		JPluginHelper::importPlugin('k2');
		$dispatcher->trigger('onK2PluginInit', array($this));
		$results = $dispatcher->trigger('onK2UserDisplay', array(&$this, &$params, 0));
		$events->K2UserDisplay = trim(implode("\n", $results));
		return $events;
	}

	public function getLatest($limit = 10, $exclude = null)
	{
		K2Model::addIncludePath(JPATH_ADMINISTRATOR.'/components/com_k2/models');
		$model = K2Model::getInstance('Items');
		$model->setState('site', true);
		$model->setState('author', $this->id);
		$model->setState('ordering', 'created');
		if ($exclude)
		{
			$model->setState('exclude', $exclude);
		}
		$model->setState('limit', $limit);
		$model->setState('limitstart', 0);
		$rows = $model->getRows();
		return $rows;
	}

	public function checkSiteAccess()
	{
		// State check
		if ((int)$this->block > 0 || (int)$this->id < 1)
		{
			throw new Exception(JText::_('K2_NOT_FOUND'), 404);
		}
		return true;
	}

	// Legacy
	public function getProfile()
	{
		$profile = new stdClass;
		$profile->userName = $this->name;
		$profile->gender = $this->gender;
		$profile->description = $this->description;
		$profile->image = $this->image;
		$profile->url = $this->site;
		return $profile;
	}

	public function __toString()
	{
		return JFactory::getUser($this->id)->name;
	}

	public function getUserImage()
	{
		return $this->image->src;
	}

	public function getAvatar()
	{
		return $this->image->src;
	}

	public function getFeed()
	{
		return $this->feedLink;
	}

	public function getUserName()
	{
		return $this->name;
	}

	public function getCounter()
	{
		return $this->comments;
	}

	public function getLatestCommentLink()
	{
		return $this->comment->link;
	}

	public function getLatestCommentText()
	{
		return $this->comment->text;
	}

	public function getLatestCommentDate()
	{
		return $this->comment->date;
	}

	public function getEvent()
	{
		return $this->events;
	}

}
