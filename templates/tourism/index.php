<?php
defined('_JEXEC') or die('Restricted access');
if (!class_exists('templateHelper'))
	require_once ('helper.php');
$helper = new templateHelper($this); // Creatig an instance of helper class
$device = $helper->device_array; // Get User Device platform and settings
if (trim($helper->browser) == 'Internet Explorer') { // HTML tag classes based on users browser (for Modernizr.js)
	if (intval($helper->version) < 7)
		$baseClasses = ' lt-ie9 lt-ie8 lt-ie7';
	if (intval($helper->version) == 7)
		$baseClasses = ' lt-ie9 lt-ie8';
	if (intval($helper->version) == 8)
		$baseClasses = ' lt-ie9';
	if (intval($helper->version) > 8)
		$baseClasses = '';
} else
	$baseClasses = ''; // Other standard browsers
echo $helper->doctype . "\n"; // Doctype based on users platform (only differs in mobile devices)
?>
<html class="no-js<?php echo $baseClasses; ?>">
	<?php
	$app = JFactory::getApplication();
	$url = JURI::base(); // Root URL
	$turl = rtrim($url, "/"); // Root URL without tailing slash
	$templatePath = $this->baseurl . '/templates/' . $this->template . '/';
	$currentMenu = $app->getMenu(); // Get current menu settings from Joomla
	$fp = $helper->checkDefaultMenu($currentMenu); // Detecting if we are in frontpage
	$currentPage = JURI::current();
	$bdclass = ($fp) ? ' frontpage' : ''; // Create a class name for body tag if we are in frontpage
	$this->setGenerator(''); // Remove Joomla generator tag
	$schedule = (stristr(JURI::getInstance()->toString(), 'schedule')) ? true : false; // Check if we are on schedules page
	$programsTable = (stristr(JURI::getInstance()->toString(), 'programs-table')) ? true : false; // Check if we are on programs-table page
	$sitename = $app->getCfg('sitename');
	// $dir_suffix = ($this->direction == 'rtl') ? '_rtl' : '';
	?>
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width">
		<meta name="google-site-verification" content="hNVmYmqorsHWellD3gmvYGlezOzxor8dcs2JHUDMdnY" />
		<?php
		$JHeader = $this->getHeadData(); // Get Joomla Native Head tags
		$this->setHeadData($helper->cleanHead($JHeader)); // Removing unwanted tags from Joomla native head
		unset($this->_styleSheets);
		unset($this->_scripts); //unset($this->_style); // Unsetting default stylesheets and script even after helpers try and adding my own files
		foreach ($this->_style as $style)
			unset($style);
		// Adding stylesheets and scripts to joomla head to prevent core to face an empty array
		$this->_styleSheets[JURI::base() . 'assets/css/style.css'] = array('mime' => "text/css", 'media' => 'all', 'attribs' => array(), 'defer' => '', 'async' => '');
		$this->_scripts[JURI::base() . 'assets/js/modernizr-2.6.2.min.js'] = array('mime' => "text/javascript", 'media' => 'all', 'attribs' => array(), 'defer' => '', 'async' => '');
		JFactory::getDocument()->addScriptDeclaration('var base = "' . JURI::base() . '"');
		?><jdoc:include type="head" />
	</head>
	<body id="bd" class="<?php echo strtolower($helper->device); ?>" data-spy="scroll" data-target="#menu">
		<header id="header">
			<div class="wrapper _white">
				<div class="container">
					<div class="row">
						<div class="col-xs-3 col-md-1">
							<h1 class="logo">
								<a href="<?php echo JURI::base(); ?>" title="<?php echo $sitename; ?>"><?php echo $sitename; ?></a>
							</h1>
						</div>
						<?php if ($helper->countModules('menu')) { ?>
							<div class="col-xs-6 col-md-9">
								<jdoc:include type="modules" name="menu" />
							</div>
						<?php } ?>
						<?php if ($helper->countModules('search')) { ?>
							<div class="col-xs-3 col-md-2">
								<jdoc:include type="modules" name="search" />
							</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</header>
		<section id="main">
			<?php if ($fp) { ?>
				<?php if ($helper->countModules('showcase')) { ?>
				<div id="home" class="page wrapper _white">
					<div class="page-inner">
						<jdoc:include type="modules" name="showcase" />
					</div>
				</div>
				<?php } ?>
				<?php if ($helper->countModules('content')) { ?>
				<div id="content" class="page wrapper _dark-gray">
					<jdoc:include type="modules" name="content" />
				</div>
				<?php } ?>
				<?php if ($helper->countModules('categories')) { ?>
				<div id="categories" class="page wrapper _green">
					<jdoc:include type="modules" name="categories" />
				</div>
				<?php } ?>
				<?php if ($helper->countModules('recommendations')) { ?>
				<div id="recommendations" class="page wrapper _dark-gray">
					<jdoc:include type="modules" name="recommendations" />
				</div>
				<?php } ?>
				<?php if ($helper->countModules('panorama')) { ?>
				<div id="panorama" class="page wrapper _white">
					<div class="page-inner">
						<jdoc:include type="modules" name="panorama" />
					</div>
				</div>
				<?php } ?>
				<?php if ($helper->countModules('interaction')) { ?>
				<div id="interaction" class="page wrapper _gray _bg-contacts">
					<jdoc:include type="modules" name="interaction" />
				</div>
				<?php } ?>
			<?php } else { // not frontpage ?>
				<div id="home" class="page component wrapper _white">
					<div class="page-inner">
						<div class="container">
							<div class="row">
								<div class="col-xs-12">
									<jdoc:include type="component" />
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php } ?>
		</section>
		<footer id="footer">
			<div class="wrapper _green">
				<div class="container">
					<?php if ($helper->countModules('copyright')) { ?>
					<div id="copyright" class="row">
						<div class="col-xs-12 text-center">
							<jdoc:include type="modules" name="copyright" />
						</div>
					</div>
					<?php } ?>
				</div>
			</div>
		</footer>
		<jdoc:include type="message" />
		<div class="modal fade zoom-out" id="item-modal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content" role="tabpanel">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title"></h4>
					</div>
					<div class="modal-body"></div>
				</div>
			</div>
		</div>
		<script src="<?php echo JURI::base(); ?>assets/js/jquery-1.11.1.min.js"></script>
		<script src="<?php echo JURI::base(); ?>assets/js/imagesloaded.pkgd.min.js"></script>
		<script src="<?php echo JURI::base(); ?>assets/js/bootstrap.min.js"></script>
		<script src="<?php echo JURI::base(); ?>assets/js/jquery.carouFredSel-6.2.1-packed.js"></script>
		<script src="<?php echo JURI::base(); ?>assets/js/main.min.js"></script>
	</body>
</html>