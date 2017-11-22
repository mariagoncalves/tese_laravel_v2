<div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
        <h4 class="modal-title" id="myModalLabel">{{trans("customForms/modalAddTransactionType.FORM_NAME")}}</h4>
    </div>
    <div class="modal-body">
       <form name="frmCustomForm" class="form-horizontal" novalidate="">

           <div class="form-group">
            <label class="col-sm-12 control-label" style="text-align: center">{{trans("customForms/modalAddTransactionType.LBL1")}} [[ customForm.language[0].pivot.name]]</label>
           </div>

           <div class="form-group">
               <label for="" class="col-sm-3 control-label">{{trans("customForms/modalAddTransactionType.INPUT_PROCESS_TYPE")}}</label>
               <div class="col-sm-9">
                   <select class="form-control" name="customform_process_type" ng-model="process_type_id" ng-options="item.language[0].pivot.process_type_id as item.language[0].pivot.name for item in process_types" required ng-change="updateTransactionTypes(0)">
                       <option value="">{{trans("customForms/modalAddTransactionType.INPUT_SELECT_PROCESS_TYPE")}}</option>
                   </select>
                   <div ng-messages="frmCustomForm.customform_process_type.$error" ng-show="frmCustomForm.customform_process_type.$invalid && frmCustomForm.customform_process_type.$touched">
                       <p ng-message="required">{{trans("customForms/modalAddTransactionType.REQUIRED_PROCESS_TYPE")}}</p>
                   </div>
               </div>
           </div>

            <div class="form-group">
                <div class="col-sm-12">
                 <label>{{trans("customForms/modalAddTransactionType.LBL2")}}</label>
                    <ui-select multiple ng-model="seltransactiontypes.sel" theme="bootstrap" style="width: 100%"
                               sortable="true" close-on-select="false" title="Choose a Transaction Type" ng-disabled="checkProcessType">
                        <ui-select-match placeholder="Transaction Types...">[[$item.name]] (Id:[[$item.id]])</ui-select-match>
                        <ui-select-choices repeat="transaction_type in transaction_types | propsFilter: {name: $select.search, id: $select.search}">
                            <div ng-bind-html="transaction_type.name | highlight: $select.search"></div>
                            (Id:<span ng-bind-html="transaction_type.id | highlight: $select.search"></span>)
                        </ui-select-choices>
                    </ui-select>
                </div>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="btn-save" ng-click="saveEnt()" ng-disabled="frmCustomForm.$invalid">{{trans("customForms/modalAddTransactionType.BTN1FORM")}}</button>
    </div>
</div>
