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
require_once JPATH_ADMINISTRATOR.'/components/com_k2/resources/users.php';
require_once JPATH_ADMINISTRATOR.'/components/com_k2/helpers/images.php';

/**
 * K2 comment resource class.
 */

class K2Comments extends K2Resource
{

	/**
	 * @var array	Items instances container.
	 */
	protected static $instances = array();

	/**
	 * @var object	Permissions.
	 */
	protected static $permissions;

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
			$model = K2Model::getInstance('Comments', 'K2Model');
			$model->setState('id', $id);
			$item = $model->getRow();
			self::$instances[$id] = $item;
		}
		return self::$instances[$id];
	}

	public static function getPermissions()
	{
		if (!isset(self::$permissions))
		{
			$user = JFactory::getUser();
			$params = JComponentHelper::getParams('com_k2');
			$permissions = new stdClass;
			$permissions->canEdit = $user->authorise('k2.comment.edit', 'com_k2');
			$permissions->canReport = $params->get('commentsReporting') == '1' || ($params->get('commentsReporting') == '2' && !$user->guest);
			$permissions->canReportUser = $user->authorise('core.admin', 'com_k2');
			self::$permissions = $permissions;
		}
		return self::$permissions;
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

		// Prepare specific properties
		$this->editLink = JURI::base(true).'/index.php?option=com_k2#comments/edit/'.$this->id;

		// Created date
		$this->createdOn = JHtml::_('date', $this->date, JText::_('K2_DATE_FORMAT'));

		// Get application
		$application = JFactory::getApplication();

		// Front-end only
		if ($application->isSite())
		{

			// Get user
			$this->user = $this->getUser();

			// Edit permission
			$this->canEdit = K2Comments::getPermissions()->canEdit;

			// Report permission
			$user = JFactory::getUser();
			$this->canReport = K2Comments::getPermissions()->canReport && $user->id != $this->userId;

			// Report user permission
			$this->canReportUser = K2Comments::getPermissions()->canReportUser && $this->userId > 0 && $user->id != $this->userId;

			// Apply no-follow to all links
			$document = new DOMDocument;
			$document->loadHTML('<?xml encoding="UTF-8"><html><body>'.$this->text.'</body></html>');
			$links = $document->getElementsByTagName('a');
			foreach ($links as $link)
			{
				$link->setAttribute('rel', 'nofollow');
			}
			$this->text = $document->saveHTML($document->getElementsByTagName('body')->item(0));
			$this->text = str_replace(array('<body>', '</body>'), '', $this->text);

			// Item link
			$this->itemLink = $this->getItemLink();

			// Category link
			$this->categoryLink = $this->getCategoryLink();

			// Is Author response?
			$this->isAuthorResponse = $this->getIsAuthorResponse();

			// Unset sensitive data if user is not authorised to edit the comment
			if (!$this->canEdit)
			{
				unset($this->email);
				unset($this->ip);
				unset($this->hostname);
			}

		}

	}

	public function getItemLink()
	{
		return JRoute::_(K2HelperRoute::getItemRoute($this->itemId.':'.$this->itemAlias, $this->categoryId));
	}

	public function getCategoryLink()
	{
		return JRoute::_(K2HelperRoute::getCategoryRoute($this->categoryId.':'.$this->categoryAlias));
	}

	public function getLink()
	{
		if (!isset($this->link))
		{
			if (!isset($this->itemLink))
			{
				$this->itemLink = $this->getItemLink();
			}
			$this->link = $this->itemLink.'#comment'.$this->id;
		}
		return $this->link;
	}

	public function getIsAuthorResponse()
	{
		return trim($this->itemCreatedByAlias) == '' && $this->userId == $this->itemCreatedBy;
	}

	public function getUser()
	{
		$user = new stdClass;
		if ($this->userId)
		{
			$instance = K2Users::getInstance($this->userId);
			$user->name = $instance->name;
			$user->username = $instance->username;
			$user->link = $instance->link;
			$user->image = $instance->image;
		}
		else
		{
			$user->name = $this->name;
			$user->username = $this->name;
			$user->link = false;
			$user->image = false;

			$params = JComponentHelper::getParams('com_k2');
			if (!$user->image && $params->get('gravatar'))
			{
				$user->image = new stdClass;
				$user->image->src = '//www.gravatar.com/avatar/'.md5($this->email).'?s='.$params->get('commenterImgWidth', 48);
				if ($params->get('userImageDefault'))
				{
					$user->image->src .= '&d='.urlencode(JURI::root(false).'/'.K2HelperImages::getPlaceholder('user'));
				}
				$user->image->url = $user->image->src;
			}
		}
		return $user;
	}

	public function getRelativeDate()
	{
		$now = JFactory::getDate();
		$configuration = JFactory::getConfig();
		$timezone = new DateTimeZone($configuration->get('offset'));
		$now->setTimezone($timezone);
		$created = JFactory::getDate($this->date);
		$diff = $now->toUnix() - $created->toUnix();
		$dayDiff = floor($diff / 86400);
		if ($dayDiff == 0)
		{
			if ($diff < 5)
			{
				$relativeDate = JText::_('K2_JUST_NOW');
			}
			elseif ($diff < 60)
			{
				$relativeDate = $diff.' '.JText::_('K2_SECONDS_AGO');
			}
			elseif ($diff < 120)
			{
				$relativeDate = JText::_('K2_1_MINUTE_AGO');
			}
			elseif ($diff < 3600)
			{
				$relativeDate = floor($diff / 60).' '.JText::_('K2_MINUTES_AGO');
			}
			elseif ($diff < 7200)
			{
				$relativeDate = JText::_('K2_1_HOUR_AGO');
			}
			elseif ($diff < 86400)
			{
				$relativeDate = floor($diff / 3600).' '.JText::_('K2_HOURS_AGO');
			}
		}
		else
		{
			$relativeDate = $this->createdOn;
		}
		return $relativeDate;
	}

	// Legacy
	public function getUserId()
	{
		return $this->userId;
	}

	public function getUserName()
	{
		return ($this->userId) ? $this->user->name : $this->name;
	}

	public function getCommentDate()
	{
		return $this->date;
	}

	public function getCommentText()
	{
		return $this->text;
	}

	public function getCommentEmail()
	{
		return $this->email;
	}

	public function getCommentUrl()
	{
		return $this->url;
	}

	public function getPublished()
	{
		return $this->state;
	}

	public function getTitle()
	{
		return $this->itemTitle;
	}

	public function getCategoryName()
	{
		return $this->categoryTitle;
	}

	public function getCatLink()
	{
		return $this->categoryLink;
	}

	public function getUserImage()
	{
		return $this->user->image->src;
	}

	public function getUserLink()
	{
		return $this->user->link;
	}

}
