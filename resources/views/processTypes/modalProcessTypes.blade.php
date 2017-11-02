
<div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" ng-click="cancel()"><span aria-hidden="true">×</span></button>
        <h4 class="modal-title" id="myModalLabel">{{trans("processTypes/modalFormTask.FORM_NAME")}}</h4>
    </div>
    <div class="modal-body">
        <form name="frmProcessTypes" class="form-horizontal" novalidate="">

            <div class="form-group">
                <label for="inputName" class="col-sm-3 control-label">{{trans("processTypes/modalFormTask.INPUT_NAME")}}</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="process_type_name" name="process_type_name" placeholder="" value="[[name]]"
                           ng-model="processtype.language[0].pivot.name" required>
                    <div ng-messages="frmProcessTypes.process_type_name.$error" ng-show="frmProcessTypes.process_type_name.$invalid && frmProcessTypes.process_type_name.$touched">
                        <p ng-message="required">{{trans("processTypes/validation.required")}} {{trans("processTypes/modalFormTask.INPUT_NAME")}}</p>
                    </div>

                </div>
            </div>

            <div class="form-group">
                <label for="Gender" class="col-sm-3 control-label">{{trans("processTypes/modalFormTask.INPUT_STATE")}}</label>
                <div class="col-sm-9">
                    <label for="" class="radio-inline state">
                        <input type="radio" name="process_type_state" value="active" ng-model="processtype.state" required>Active
                    </label>
                    <label for="" class="radio-inline state">
                        <input type="radio" name="process_type_state" value="inactive" ng-model="processtype.state" required>Inactive
                    </label>
                    <div ng-messages="frmProcessTypes.process_type_state.$error" ng-show="frmProcessTypes.process_type_state.$invalid && frmProcessTypes.process_type_state.$touched">
                        <p ng-message="required">{{trans("processTypes/validation.required")}} {{trans("processTypes/modalFormTask.INPUT_STATE")}}</p>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="Language" class="col-sm-3 control-label">{{trans("processTypes/modalFormTask.INPUT_LANGUAGE")}}</label>
                <div class="col-sm-9">
                    <select class="form-control" name="language_id" ng-model="processtype.language[0].id" ng-options="item.id as item.slug for item in langs" required>
                        <option value="">{{trans("processTypes/modalFormTask.INPUT_language_id")}}</option>
                    </select>
                    <div ng-messages="frmProcessTypes.language_id.$error" ng-show="frmProcessTypes.language_id.$invalid && frmProcessTypes.language_id.$touched">
                        <p ng-message="required">{{trans("processTypes/validation.required")}} {{trans("processTypes/modalFormTask.INPUT_LANGUAGE")}}</p>
                    </div>
                </div>
                <br>
                <ul ng-repeat="error in errors">
                    <li>[[ error[0] ]]</li>
                </ul>

            </div>
        </form>
    </div>
    <div class="modal-footer"><!-- ng-disabled="frmProcessTypes.$invalid" -->
        <button type="button" class="btn btn-green" id="btn-save" ng-disabled="frmProcessTypes.$invalid" ng-click="save()" >{{trans("processTypes/modalFormTask.BTN1FORM")}}</button>
    </div>
</div>