
                                <div class="panel panel-info">
                                    <div class="panel-heading">
                                        <h3 class="panel-title" ng-if="modal_formTab[index].relTypeExist==false">[[modal_formTab[index].propsform[0].ent_type.language[0].pivot.name]] [[type-1]]</h3>
                                        <h3 class="panel-title" ng-if="modal_formTab[index].relTypeExist==true">[[modal_formTab[index].propsform[0].rel_type.language[0].pivot.name]] [[type-1]]</h3>
                                    </div>
                                    <div class="panel-body">
                                <form name="frmTaskForm" class="form-horizontal" novalidate="">
                                    <div ng-if="modal_formTab[index].relTypeExist==true">
                                        <div class="form-group">
                                            <label for="inputTransactionType" class="col-sm-3 control-label">Entity 1:</label>
                                            <div class="col-sm-9">
                                                <ui-select ng-model="modal_formTab.entity1.selected" theme="bootstrap">
                                                    <ui-select-match placeholder="Select or search a process type">[[$select.selected.language[0].pivot.name]]</ui-select-match>
                                                    <ui-select-choices repeat="item in entities1 | filter: $select.search">
                                                        <div ng-bind-html="item.language[0].pivot.name | highlight: $select.search"></div>
                                                    </ui-select-choices>
                                                </ui-select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputTransactionType" class="col-sm-3 control-label">Entity 2:</label>
                                            <div class="col-sm-9">
                                                <ui-select ng-model="modal_formTab.entity2.selected" theme="bootstrap">
                                                    <ui-select-match placeholder="Select or search a process type">[[$select.selected.language[0].pivot.name]]</ui-select-match>
                                                    <ui-select-choices repeat="item in entities2 | filter: $select.search">
                                                        <div ng-bind-html="item.language[0].pivot.name | highlight: $select.search"></div>
                                                    </ui-select-choices>
                                                </ui-select>
                                            </div>
                                        </div>
                                    </div>



                                    <div ng-repeat="prop in modal_formTab[index].propsform" ng-switch="prop.value_type" emit-last-repeater-element>
                                        <div class="form-group" ng-switch-when="text|double|int" ng-switch-when-separator="|">
                                            <label for="inputName" class="col-sm-3 control-label">[[prop.language[0].pivot.name]]</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="[[prop.language[0].pivot.form_field_name]]" name="[[prop.language[0].pivot.form_field_name]]" placeholder=""
                                                       ng-model="modal_formTab[index].fields[prop.language[0].pivot.form_field_name]">
                                                <span class="help-inline"
                                                      ng-show="frmTaskForm.transactiontype_t_name.$invalid && frmTaskForm.transactiontype_t_name.$touched">Name field is required</span>
                                            </div>
                                        </div>

                                        <div class="form-group" ng-switch-when="bool">
                                            <label for="inputName" class="col-sm-3 control-label">[[prop.language[0].pivot.name]]</label>
                                            <div class="col-sm-9">
                                                <label for="" class="radio-inline state">
                                                    <input type="radio" name="[[prop.language[0].pivot.form_field_name]]" value="active" ng-model="modal_formTab[index].fields[prop.language[0].pivot.form_field_name]" required>Active
                                                </label>
                                                <label for="" class="radio-inline state">
                                                    <input type="radio" name="[[prop.language[0].pivot.form_field_name]]" value="inactive" ng-model="modal_formTab[index].fields[prop.language[0].pivot.form_field_name]" required>Inactive
                                                </label>
                                                <span class="help-inline"
                                                      ng-show="frmTaskForm.transactiontype_t_name.$invalid && frmTaskForm.transactiontype_t_name.$touched">Name field is required</span>
                                            </div>
                                        </div>

                                        <div class="form-group" ng-switch-when="enum" ng-switch="prop.form_field_type">
                                            <label for="inputName" class="col-sm-3 control-label">[[prop.language[0].pivot.name]]</label>
                                            <div class="col-sm-9" ng-switch-when="radio|checkbox" ng-switch-when-separator="|">
                                                <label for="" class="radio-inline state">
                                                    <input ng-repeat="p_a_v in prop.prop_allowed_values" ng-model="modal_formTab[index].fields[prop.language[0].pivot.form_field_name]" type="[[prop.form_field_type]]" name="[[prop.language[0].pivot.form_field_name]]" value="[[p_a_v.id]]" required>[[p_a_v.language[0].pivot_name]]
                                                </label>
                                                <span class="help-inline"
                                                      ng-show="frmTaskForm.transactiontype_t_name.$invalid && frmTaskForm.transactiontype_t_name.$touched">Name field is required</span>
                                            </div>

                                            <div class="col-sm-9" ng-switch-when="selectbox">
                                                <select class="form-control" ng-model="modal.task_id" ng-change="verParEntType(modal.task_id, index)" ng-options="item.id as item.language[0].pivot.name for item in prop.prop_allowed_values">
                                                    <option value=""></option>
                                                </select>
                                                <span class="help-inline"
                                                      ng-show="frmTaskForm.transactiontype_t_name.$invalid && frmTaskForm.transactiontype_t_name.$touched">Name field is required</span>
                                            </div>
                                        </div>

                                        <div class="form-group" ng-switch-when="ent_ref">
                                            <label for="inputName" class="col-sm-3 control-label">[[prop.language[0].pivot.name]]</label>
                                            <div class="col-sm-9">
                                                <select class="form-control" ng-model="modal_formTab[index].fields[prop.language[0].pivot.form_field_name]" ng-options="item.id as item.language[0].pivot.name for item in prop.fk_ent_type.entity">
                                                    <option value=""></option>
                                                </select>
                                                <span class="help-inline"
                                                      ng-show="frmTaskForm.transactiontype_t_name.$invalid && frmTaskForm.transactiontype_t_name.$touched">Name field is required</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div ng-if="modal_formTab[index].showMessage">
                                        <div ng-include="templatePath" onload="index=myIndex;propsform_=myPropsform_;relTypeExist_=myRelTypeExist_"></div>
                                    </div>
                                </form>
                                    </div>
                                </div>

                                <div growl reference="2">
                                </div>
                                <div ng-if="modal_formTab[index].showBtnType==true">
                                    <button type="button" class="btn btn-default btn-blue" ng-click="changeTabBootChild(trans_id, 'Task Form Child', 'tabFormTaskChild', tabnumber, type, indexChildTab, tstatescan)">Next</button>
                                </div>
                                <div ng-if="modal_formTab[index].showBtnType==false">
                                    <button type="button" class="btn btn-default btn-blue" ng-click="changeTabBoot_(trans_id, 'Task Form', 'tabFormTask', 1)">Next</button>
                                </div>