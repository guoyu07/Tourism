<?php
/**
 * File name: $HeadURL: svn://tools.janguo.de/jacc/trunk/admin/templates/modules/tmpl/default.php $
 * Revision: $Revision: 147 $
 * Last modified: $Date: 2013-10-06 10:58:34 +0200 (So, 06. Okt 2013) $
 * Last modified by: $Author: michel $
 * @copyright	Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license 
 */
defined('_JEXEC') or die('Restricted access');
?>
<div class="panel interaction">
	<div class="panel-heading">
		<h2>تماس با ما</h2>
	</div>
	<div class="container">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="text-center alert">
					<p>شما می توانید آثار خود ، منجمله ویدیو ها و تصاویرتان را با ما در اشترک بگذارید.</p>
					<p>برای ارسال آثارتان، <a href="#" data-toggle="modal" data-target="#upload-modal">اینجا</a> را کلیک کتید.</p>
				</div>
				<form role="form" action="#" method="post" class="contact-form">
					<ul class="list-unstyled contact-details">
						<li>
							<span class="title">
								<i class="icon-fax"></i>تلفکس
							</span>22652918
						</li>
						<li>
							<span class="title">
								<i class="icon-phone"></i>تلفن گوياي شبكه
							</span>27869000
						</li>
						<li>
							<span class="title">
								<i class="icon-chat"></i>پیامک
							</span>3000080
						</li>
						<li>
							<span class="title">
								<i class="icon-mail"></i>پست الکترونیکی
							</span><a href="mailto:intl@mostanadtv.com">intl@mostanadtv.com</a>
						</li>
						<li>
							<span class="title">
								<i class="icon-placeholder"></i>ماهواره
							</span>بدر (عربست) فرکانس 11900عمودي 27500
						</li>
					</ul>
					<div class="form-group">
						<input type="text" name="name" class="form-control" placeholder="نام" />
					</div>
					<div class="form-group">
						<input type="text" name="email" class="form-control" placeholder="آدرس ایمیل" />
					</div>
					<div class="form-group">
						<textarea class="form-control" placeholder="پیام" rows="3"></textarea>
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-success pull-left">ارسال</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>