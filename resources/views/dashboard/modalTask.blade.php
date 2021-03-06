
                <div growl reference="[[index]]">
                </div>
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" ng-click="cancel()" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <h4 class="modal-title" id="myModalLabel">{{trans("dashboard/modalTask.Modal_Name")}}</h4>
                    </div>
                    <div class="modal-body">
                        <form name="frmTaskForm" class="form-horizontal" novalidate="">
                        <uib-tabset active="activeTabIndex" type="tabs">
                            <uib-tab ng-repeat="tab in tabs" index="$index" heading="[[tab.title]]" disable="tab.disabled">
                                <br>
                                <div ng-include="tab.templateUrl" onload="log(myPromise);indexTab=myindexTab;propsform=myPropsform;relTypeExist=myRelTypeExist;type=mytype;tabnumber=myTabNumber"></div>
                            </uib-tab>
                        </uib-tabset>
                        </form>
                    </div>
                    <div class="modal-footer"><!-- ng-disabled="frmTaskForm.$invalid || tabs.length==1" -->
                        <button type="button" ng-disabled="frmTaskForm.$invalid || (tabs.length===1 && tabs[0].title==='Process')" class="btn btn-lg btn-light-green" id="btn-save" ng-click="save(modal_formTab, modalInstance)" >{{trans("dashboard/modal.BTN_SAVE")}}</button>
                    </div>
                </div>