define(['marionette', 'text!templates/categories/edit.html', 'dispatcher', 'widget', 'views/extrafields/widget', 'views/image/widget'], function(Marionette, template, K2Dispatcher, K2Widget, K2ViewExtraFieldsWidget, K2ViewImageWidget) {'use strict';

	// K2 category form view
	var K2ViewCategory = Marionette.LayoutView.extend({

		// Template
		template : _.template(template),

		// Regions
		regions : {
			imageRegion : '[data-region="category-image"]',
			extraFieldsRegion : '[data-region="category-extra-fields"]'
		},

		// UI events
		events : {
			'click [data-action="select-association"]' : 'selectAssociation'
		},

		// Model events
		modelEvents : {
			'change' : 'render'
		},

		// Initialize
		initialize : function() {

			// Image
			this.imageView = new K2ViewImageWidget({
				row : this.model,
				type : 'category'
			});

			// Extra fields
			this.extraFieldsView = new K2ViewExtraFieldsWidget({
				data : this.model.getForm().get('extraFields'),
				filterId : 0,
				resourceId : this.model.get('id'),
				scope : 'category'
			});

		},

		// Serialize data for view
		serializeData : function() {
			var data = {
				'row' : this.model.toJSON(),
				'form' : this.model.getForm().toJSON()
			};
			return data;
		},

		onShow : function() {

			this.imageRegion.show(this.imageView);
			this.extraFieldsRegion.show(this.extraFieldsView);
			this.extraFieldsView.render();

		},

		// OnBeforeSave event
		onBeforeSave : function() {

			// Update form from editor contents
			K2Editor.save('description');

			// Validate extra fields
			var result = this.extraFieldsView.validate();

			return result;
		},

		// onBeforeDestroy event ( Marionette.js build in event )
		onBeforeDestroy : function() {
			// Destroy the editor. This is required by TinyMCE in order to be able to re-initialize with out page refresh.
			if ( typeof (tinymce) != 'undefined' && parseInt(tinymce.majorVersion) === 4) {
				tinymce.remove();
			}
		},
		selectAssociation : function(event) {
			event.preventDefault();
			var language = jQuery(event.currentTarget).data('language');
			window.K2SelectRow = function(row) {
				if (row.get('language') != language) {
					alert(l('K2_THIS_RESOURCE_IS_NOT_ASSIGNED_TO_THE_REQUIRED_LANGUAGE'));
					return false;
				}
				jQuery('[data-role="association-title"][data-language="' + language + '"]').text(row.get('title'));
				jQuery('input[name="associations[' + language + ']"]').val(row.get('id'));
				jQuery.magnificPopup.close();
			};
			require(['magnific', 'css!magnificStyle'], _.bind(function() {
				jQuery.magnificPopup.open({
					alignTop : false,
					closeBtnInside : true,
					items : {
						src : 'index.php?option=com_k2&tmpl=component#modal/categories',
						type : 'iframe'
					}
				});
			}, this));
		},

		// OnDomRefresh event ( Marionette.js build in event )
		onDomRefresh : function() {

			// Initialize the editor
			K2Editor.init();

			// Restore Joomla! modal events
			if ( typeof (SqueezeBox) !== 'undefined') {
				SqueezeBox.initialize({});
				SqueezeBox.assign($$('a.modal-button'), {
					parse : 'rel'
				});
			}
			// Setup widgets
			K2Widget.updateEvents(this.$el);

		}
	});
	return K2ViewCategory;
});
