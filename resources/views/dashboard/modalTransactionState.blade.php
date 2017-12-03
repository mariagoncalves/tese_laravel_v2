
                <div growl reference="[[index]]"></div>
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" ng-click="cancel()" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <h4 class="modal-title" id="myModalLabel">{{trans("dashboard/modalTransactionState.Modal_Name")}}</h4>
                    </div>
                    <div class="modal-body">
                        <form name="frmTaskForm" class="form-horizontal" novalidate="">
                        <uib-tabset active="activeTabIndex" type="tabs">
                            <uib-tab ng-repeat="tab in tabs" index="$index" heading="[[tab.title]]">
                                <br>
                                <div ng-include="tab.templateUrl" onload="index=myindex;indexTab=myindexTab;propsform=myPropsform;relTypeExist=myRelTypeExist;type=mytype;message=myMessage"></div>
                            </uib-tab>
                        </uib-tabset>
                        </form>
                    </div>
                    <div class="modal-footer"><!-- ng-disabled="frmProcessTypes.$invalid" -->
                        <button type="button" ng-disabled="frmTaskForm.$invalid || (tabs.length===1 && tabs[0].title==='Transaction State' && modal_formTab.tab.length===0)" class="btn btn-lg btn-light-green" id="btn-save" ng-click="save(modal_formTab, modalInstance)" >{{trans("dashboard/modal.BTN_SAVE")}}</button>
                    </div>
                </div>