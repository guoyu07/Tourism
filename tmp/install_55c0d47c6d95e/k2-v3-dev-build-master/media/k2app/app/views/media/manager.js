define(['marionette', 'dispatcher', 'text!templates/media/manager.html', 'jqueryui'], function(Marionette, K2Dispatcher, template) {'use strict';
	var K2ViewMediaManager = Marionette.ItemView.extend({
		template : _.template(template),
		onRender : function() {
			require(['elfinder', 'css!//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/themes/smoothness/jquery-ui.css', 'css!elfinderTheme', 'css!elfinderStyle'], _.bind(function() {
				var callback = this.options.callback;
				var modal = this.options.modal;
				var options = {
					url : 'index.php?option=com_k2&task=media.connector&format=json',
					useBrowserHistory : false
				};
				if (modal) {
					options.getFileCallback = function(data) {
						K2Dispatcher.trigger(callback, data.path);
						if (modal) {
							jQuery.magnificPopup.close();
						}
					};
				}
				this.$el.elfinder(options).elfinder('instance');
			}, this));
		},
		onShow : function() {
			K2Dispatcher.trigger('app:menu:active', 'media');
			if (this.options.modal) {
				require(['magnific', 'css!magnificStyle'], _.bind(function() {
					jQuery.magnificPopup.open({
						alignTop : false,
						closeBtnInside : true,
						items : {
							src : this.el,
							type : 'inline'
						}
					});
				}, this));
			}
		}
	});
	return K2ViewMediaManager;
});
