
                               {{-- <form name="frmTransactionTypes" class="form-horizontal" novalidate="">--}}

                                    <div class="form-group">
                                        <label for="inputTransactionType" class="col-sm-3 control-label">Process:</label>
                                        <div class="col-sm-9">
                                            <ui-select ng-model="modal_processTab.process.selected" theme="bootstrap">
                                                <ui-select-match placeholder="Select or search a process">[[$select.selected.language[0].pivot.name]]</ui-select-match>
                                                <ui-select-choices repeat="item in process | filter: $select.search">
                                                    <div ng-bind-html="item.language[0].pivot.name | highlight: $select.search"></div>
                                                </ui-select-choices>
                                            </ui-select>
                                        </div>
                                    </div>
                                {{--</form>--}}

                               <button type="button" class="btn btn-default btn-blue" ng-disabled="cantAdvance" ng-click="all('Task', 'tabFormTask', 1, modal_processTab.process.selected)">Next</button>