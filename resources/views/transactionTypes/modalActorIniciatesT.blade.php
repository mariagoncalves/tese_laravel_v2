<div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
        <h4 class="modal-title" id="myModalLabel">[[form_title | translate]]</h4>
    </div>
    <div class="modal-body">
        <form name="frmUnitTypes" class="form-horizontal" novalidate="">
            <div class="form-group">
                <label class="col-sm-12 control-label" style="text-align: center">[[ "LBL1" | translate]] [[ transactiontype.language[0].pivot.t_name]]</label>
                <div class="col-sm-12">
                    <label>[[ "LBL2" | translate]]</label>
                    <ui-select multiple ng-model="selactors.sel" theme="bootstrap" style="width: 100%"
                               sortable="true" close-on-select="false" title="Choose Actors">
                        <ui-select-match placeholder="Actors...">[[$item.name]] (Id:[[$item.id]])</ui-select-match>
                        <ui-select-choices repeat="actor in actors | propsFilter: {name: $select.search, id: $select.search}">
                            <div ng-bind-html="actor.name | highlight: $select.search"></div>
                            (Id:<span ng-bind-html="actor.id | highlight: $select.search"></span>)
                        </ui-select-choices>
                    </ui-select>
                </div>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="btn-save" ng-click="saveActor()">[[ "BTN1FORM" | translate]]</button>
    </div>
</div>
