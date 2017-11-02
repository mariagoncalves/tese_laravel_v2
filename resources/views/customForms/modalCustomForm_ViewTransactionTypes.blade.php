<div class="modal-content">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
		<h4 class="modal-title" id="myModalLabel">[[ form_title | translate]] [[ customForm.language[0].pivot.name ]]</h4>
	</div>

	<div class="modal-body">
		<div class="form-group">
			<label class="col-sm-12 control-label" style="text-align: center">[[ customForm.language[0].pivot.name ]]</label>
			<label class="col-sm-12 control-label" style="text-align: left">[[ "LBL3" | translate]]</label>
			<div class="col-sm-12">
				<table class="table" >
					<thead>
					<tr>
						<th>[[ "THEADER1VIEW1" | translate]]</th>
						<th>[[ "THEADER1VIEW2" | translate]]</th>
						<th>[[ "THEADER1VIEW3" | translate]]</th>
						{{--<th>[[ "T2HEADER4" | translate]]</th>--}}
						{{--<th><button class="btn btn-success btn-xs btn-detail" ng-click="openModalForm_2('md', customForm_id, 'add_ent_types')">[["BTNTABLE4" | translate]]</button></th>--}}
					</tr>
					</thead>
					<tbody>
					<tr ng-repeat="transaction_type in customForm.transaction_types">
						<td>[[ transaction_type.id ]]</td>
						<td>[[ transaction_type.language[0].pivot.t_name ]]</td>
						<td>[[ transaction_type.updated_at]]</td>
						<td>
							<button class="btn btn-danger btn-xs btn-delete" id="btn-delete" ng-click="removeTransactionType(customForm.id,transaction_type.id)">[["BTNREMOVE_ENT_TYPES" | translate]]</button>
						</td>
					</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<div class="modal-footer">

	</div>
</div>
