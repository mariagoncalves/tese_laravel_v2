<div class="modal-content">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
		<h4 class="modal-title" id="myModalLabel">[[ form_title | translate]]</h4>
	</div>

	<div class="modal-body">
		<h4>[[ "Page_Name" | translate]]</h4>
		<ul ui-sortable="sortableOptionsTransactionType" ng-model="transactiontypes" class="list-group">
			<li ng-repeat="transactiontype in transactiontypes" class="list-group-item" data-id="[[ transactiontype.id ]]">[[transactiontype.language[0].pivot.t_name]]</li>
			<li ng-model="customformid" style="display:none;" > </li>
		</ul>

		<pre>[[enttypes]]</pre>
	</div>
</div>
