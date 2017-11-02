<div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
        <h4 class="modal-title" id="myModalLabel">[[form_title | translate]]</h4>
    </div>
    <div class="modal-body">
        <form name="frmCustomForms" class="form-horizontal" novalidate="">

            <div class="form-group">
                <label for="inputName" class="col-sm-3 control-label">[["INPUT_NAME" | translate]]</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="custom_form_name" name="custom_form_name" placeholder="" value="@]]name]]"
                           ng-model="custom_Form.language[0].pivot.name" ng-required="true">
                    <div ng-messages="frmCustomForms.custom_form_name.$error" ng-show="frmCustomForms.custom_form_name.$invalid && frmCustomForms.custom_form_name.$touched">
                        <p ng-message="required">[["REQUIRED_NAME_PROP_ALLOW" | translate]]</p>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="" class="col-sm-3 control-label"> T State </label>
                <div class="col-sm-9">
                    <select class="form-control" name="customFormTState" ng-disabled="checkProp" ng-model="custom_Form.t_state_id" ng-options="item.language[0].pivot.t_state_id as item.language[0].pivot.name for item in tStates" required>
                        <option value="">Selecionar T State</option>
                    </select>
                    <div ng-messages="frmCustomForms.customFormTState.$error" ng-show="frmCustomForms.customFormTState.$invalid && frmCustomForms.customFormTState.$touched">
                        <p ng-message="required">[["REQUIRED_PROP_ALLOWED" | translate]]</p>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="Gender" class="col-sm-3 control-label">[["INPUT_STATE" | translate]]</label>
                <div class="col-sm-9">
                    <label for="" class="radio-inline state">
                        <input type="radio" name="custom_form_state" value="active" ng-model="custom_Form.state" required>Active
                    </label>
                    <label for="" class="radio-inline state">
                        <input type="radio" name="custom_form_state" value="inactive" ng-model="custom_Form.state" required>Inactive
                    </label>
                    <div ng-messages="frmCustomForms.custom_form_state.$error" ng-show="frmCustomForms.custom_form_state.$invalid && frmCustomForms.custom_form_state.$touched">
                        <p ng-message="required">[["REQUIRED_STATE_PROP_ALLOW" | translate]]</p>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="btn-save" ng-click="save()" ng-disabled="frmCustomForms.$invalid">[[ "BTN1FORM" | translate]]</button>
    </div>
</div>