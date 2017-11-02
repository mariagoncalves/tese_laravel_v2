
<div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
        <h4 class="modal-title" id="myModalLabel">[[ form_title | translate]]</h4>
    </div>
    <div class="modal-body">
        <form name="frmTransactionTypes" class="form-horizontal" novalidate="">

            <div class="form-group">
                <label for="inputName" class="col-sm-3 control-label">[[ "INPUT_NAME" | translate]]</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="transactiontype_t_name" name="transactiontype_t_name" placeholder=""
                           ng-model="entitytype.language[0].pivot.name">
                    <span class="help-inline"
                          ng-show="frmTransactionTypes.transactiontype_t_name.$invalid && frmTransactionTypes.transactiontype_t_name.$touched">[[ "REQUIRED_FIELD" | translate:translationData]]</span>
                </div>
            </div>

            <div class="form-group">
                <label for="inputTransactionType" class="col-sm-3 control-label">[[ "INPUT_TRANSACTION_TYPE" | translate]]</label>
                <div class="col-sm-9">
                    <select class="form-control" ng-model="entitytype.transaction_type_id" ng-options="item.id as item.language[0].pivot.t_name for item in transactiontypes">
                        <option value="">[[ "INPUT_transaction_type_id" | translate]]</option>
                    </select>
                    <span class="help-inline"
                          ng-show="frmTransactionTypes.language_id.$invalid && frmTransactionTypes.language_id.$touched">State field is required</span>
                </div>
                <br>
                <ul ng-repeat="error in errors">
                    <li>[[ error[0] ]]</li>
                </ul>

            </div>

            <div class="form-group">
                <label for="inputEntType" class="col-sm-3 control-label">[[ "INPUT_ENTITY_TYPE" | translate]]</label>
                <div class="col-sm-9">
                    <select class="form-control" ng-model="entitytype.par_ent_type_id" ng-options="item.id as item.language[0].pivot.name for item in enttypes">
                        <option value="">[[ "INPUT_entity_type_id" | translate]]</option>
                    </select>
                    <span class="help-inline"
                          ng-show="frmTransactionTypes.language_id.$invalid && frmTransactionTypes.language_id.$touched">State field is required</span>
                </div>
                <br>
                <ul ng-repeat="error in errors">
                    <li>[[ error[0] ]]</li>
                </ul>

            </div>

            <div class="form-group">
                <label for="inputEntType" class="col-sm-3 control-label">[[ "INPUT_PROP_ALL_VAL" | translate ]]</label>
                <div class="col-sm-9">
                    <select class="form-control" ng-model="entitytype.par_prop_type_val" ng-options="item.id as item.language[0].pivot.name for item in propallowedvals">
                        <option value="">[[ "INPUT_prop_all_val" | translate]]</option>
                    </select>
                    <span class="help-inline"
                          ng-show="frmTransactionTypes.par_prop_type_val.$invalid && frmTransactionTypes.par_prop_type_val.$touched">State field is required</span>
                </div>
                <br>
                <ul ng-repeat="error in errors">
                    <li>[[ error[0] ]]</li>
                </ul>

            </div>

            <div class="form-group">
                <label for="Gender" class="col-sm-3 control-label">[[ "INPUT_STATE" | translate]]</label>
                <div class="col-sm-9">
                    <label for="" class="radio-inline state">
                        <input type="radio" name="transactiontype_state" value="active" ng-model="entitytype.state" required>Active
                    </label>
                    <label for="" class="radio-inline state">
                        <input type="radio" name="transactiontype_state" value="inactive" ng-model="entitytype.state" required>Inactive
                    </label>
                    <span class="help-inline"
                          ng-show="frmTransactionTypes.process_state.$invalid && frmTransactionTypes.process_state.$touched">State field is required</span>
                </div>
            </div>

            <div class="form-group">
                <label for="Gender" class="col-sm-3 control-label">[[ "INPUT_TRANSACTION_STATE" | translate]]</label>
                <div class="col-sm-9">
                    <select class="form-control" ng-model="entitytype.t_state_id" ng-options="item.language[0].pivot.t_state_id as item.language[0].pivot.name for item in tstates">
                        <option value="">[[ "INPUT_transaction_state_id" | translate]]</option>
                    </select>
                    <span class="help-inline"
                          ng-show="frmTransactionTypes.language_id.$invalid && frmTransactionTypes.language_id.$touched">State field is required</span>
                </div>
                <br>
                <ul ng-repeat="error in errors">
                    <li>[[ error[0] ]]</li>
                </ul>

            </div>

            <div class="form-group">
                <label for="Gender" class="col-sm-3 control-label">[[ "INPUT_LANGUAGE" | translate]]</label>
                <div class="col-sm-9">
                    <select class="form-control" ng-model="entitytype.language[0].id" ng-options="item.id as item.slug for item in langs">
                        <option value="">[[ "INPUT_language_id" | translate]]</option>
                    </select>
                    <span class="help-inline"
                          ng-show="frmTransactionTypes.language_id.$invalid && frmTransactionTypes.language_id.$touched">State field is required</span>
                </div>
                <br>
                <ul ng-repeat="error in errors">
                    <li>[[ error[0] ]]</li>
                </ul>

            </div>
        </form>
    </div>
    <div class="modal-footer"><!-- ng-disabled="frmProcessTypes.$invalid" -->
        <button type="button" class="btn btn-green" id="btn-save" ng-click="save()" >[[ "BTN1FORM" | translate]]</button>
    </div>
</div>