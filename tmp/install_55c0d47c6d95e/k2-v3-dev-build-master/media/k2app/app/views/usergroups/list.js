define(['marionette', 'text!templates/usergroups/list.html', 'text!templates/usergroups/row.html', 'dispatcher'], function(Marionette, list, row, K2Dispatcher) {'use strict';
	var K2ViewUserGroupsRow = Marionette.ItemView.extend({
		tagName : 'ul',
		template : _.template(row),
		events : {
			'click a[data-action="edit"]' : 'edit'
		},
		edit : function(event) {
			event.preventDefault();
			K2Dispatcher.trigger('app:controller:edit', this.model.get('id'));
		}
	});
	var K2ViewUserGroups = Marionette.CompositeView.extend({
		template : _.template(list),
		childViewContainer : '[data-region="list"]',
		childView : K2ViewUserGroupsRow
	});
	return K2ViewUserGroups;
});
