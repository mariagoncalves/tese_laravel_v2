<div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" ng-click="cancel()"><span aria-hidden="true">×</span></button>
        <h4 class="modal-title" id="myModalLabel"> [[form_title | translate]] </h4>
    </div>
    <div class="modal-body">
        <form name="frmUnitTypes" class="form-horizontal" novalidate="">

            <div class="form-group">
                <label for="inputName" class="col-sm-3 control-label">[["INPUT_NAME" | translate]]</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="prop_unit_type_name" name="prop_unit_type_name" placeholder="" value="@]]name]]"
                           ng-model="propUnitType.language[0].pivot.name" ng-required="true">
                    <div ng-messages="frmUnitTypes.prop_unit_type_name.$error" ng-show="frmUnitTypes.prop_unit_type_name.$invalid && frmUnitTypes.prop_unit_type_name.$touched">
                        <p ng-message="required">[["REQUIRED_NAME_PROP_ALLOW" | translate]]</p>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="Gender" class="col-sm-3 control-label">[["INPUT_STATE" | translate]]</label>
                <div class="col-sm-9">
                    <label for="" class="radio-inline state">
                        <input type="radio" name="prop_unit_type_state" value="active" ng-model="propUnitType.state" required>Active
                    </label>
                    <label for="" class="radio-inline state">
                        <input type="radio" name="prop_unit_type_state" value="inactive" ng-model="propUnitType.state" required>Inactive
                    </label>
                    <div ng-messages="frmUnitTypes.prop_unit_type_state.$error" ng-show="frmUnitTypes.prop_unit_type_state.$invalid && frmUnitTypes.prop_unit_type_state.$touched">
                        <p ng-message="required">[["REQUIRED_STATE_UNIT" | translate]]</p>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="btn-save" ng-click="save()" ng-disabled="frmUnitTypes.$invalid">[[ "BTN1FORM" | translate]]</button>
    </div>
</div>
