<div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
        <h4 class="modal-title" id="myModalLabel">[[form_title | translate]]</h4>
    </div>
    <div class="modal-body">
       <form name="frmUnitTypes" class="form-horizontal" novalidate="">
            <div class="form-group">
                <label class="col-sm-12 control-label" style="text-align: center">[[ "LBL1" | translate]] [[ customForm.language[0].pivot.name]]</label>
                <div class="col-sm-12">
                 <label>[[ "LBL2" | translate]]</label>
                    <ui-select multiple ng-model="seltransactiontypes.sel" theme="bootstrap" style="width: 100%"
                               sortable="true" close-on-select="false" title="Choose a Transaction Type">
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
        <button type="button" class="btn btn-primary" id="btn-save" ng-click="saveEnt()">[[ "BTN1FORM" | translate]]</button>
    </div>
</div>
