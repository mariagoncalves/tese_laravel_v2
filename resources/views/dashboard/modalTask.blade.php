
                <div growl reference="[[index]]">
                </div>
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" ng-click="cancel()" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <h4 class="modal-title" id="myModalLabel">Add New Task</h4>
                    </div>
                    <div class="modal-body">
                        <form name="frmTaskForm" class="form-horizontal" novalidate="">
                        <uib-tabset active="activeTabIndex" type="tabs">
                            <uib-tab ng-repeat="tab in tabs" index="$index" heading="[[tab.title]]" disable="tab.disabled">
                                <br>
                                <div ng-include="tab.templateUrl" onload="index=myindex;indexTab=myindexTab;propsform=myPropsform;relTypeExist=myRelTypeExist;type=mytype;trans_id=myTransID;tabnumber=myTabNumber"></div>
                            </uib-tab>
                        </uib-tabset>
                        </form>
                    </div>
                    <div class="modal-footer"><!-- ng-disabled="frmTaskForm.$invalid || tabs.length==1" -->
                        <button type="button" ng-disabled="frmTaskForm.$invalid || tabs[0].title=='Process'" class="btn btn-lg btn-light-green" id="btn-save" ng-click="save(modal_formTab[index])" >{{trans("processTypes/modalFormTask.BTN1FORM")}}</button>
                    </div>
                </div>