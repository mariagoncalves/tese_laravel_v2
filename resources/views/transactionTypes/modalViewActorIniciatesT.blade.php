<div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
        <h4 class="modal-title" id="myModalLabel">[[ form_title | translate]] [[ transactionType.language[0].pivot.t_name ]]</h4>
    </div>

    <div class="modal-body">
        <div class="form-group">
            <label class="col-sm-12 control-label" style="text-align: center">[[ transactionType.language[0].pivot.t_name ]]</label>
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
                    <tr ng-repeat="actor in transactionType.iniciator_actor">
                        <td>[[ actor.id ]]</td>
                        <td>[[ actor.language[0].pivot.name ]]</td>
                        <td>[[ actor.updated_at]]</td>
                        <td>
                            <button class="btn btn-danger btn-xs btn-delete" id="btn-delete" ng-click="removeActor(transactionType.id,actor.id)">[["BTNREMOVE_ENT_TYPES" | translate]]</button>
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
