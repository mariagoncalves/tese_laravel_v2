                        [[index]] [[indexTab]]
                            <div class="panel-heading">
                                <h3 class="panel-title" ng-if="modal_formTab[index].tab[indexTab].relTypeExist_==false">[[modal_formTab[index].tab[indexTab].propsform_[0].ent_type.language[0].pivot.name]] [[type-1]]</h3>
                                <h3 class="panel-title" ng-if="modal_formTab[index].tab[indexTab].relTypeExist_==true">[[modal_formTab[index].tab[indexTab].propsform_[0].rel_type.language[0].pivot.name]] [[type-1]]</h3>
                            </div>
                                <form name="frmTaskForm" class="form-horizontal" novalidate="">
                                    <div ng-if="modal_formTab[index].tab[indexTab].relTypeExist_==true">
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



                                    <div ng-repeat="prop in modal_formTab[index].tab[indexTab].propsform_" ng-switch="prop.value_type" emit-last-repeater-element>
                                        <div class="form-group" ng-switch-when="text|double|int" ng-switch-when-separator="|" ng-switch="prop.form_field_type">
                                            <label for="inputName" class="col-sm-3 control-label">[[prop.language[0].pivot.name]]</label>
                                            <div class="col-sm-9" ng-switch-when="text">
                                                <input type="text" class="form-control" id="[[prop.language[0].pivot.form_field_name]]" name="[[prop.language[0].pivot.form_field_name]]" placeholder=""
                                                       ng-model="prop.fields[prop.language[0].pivot.form_field_name+'-'+prop.id]" maxlength="[[prop.form_field_size]]" ng-required="prop.mandatory">
                                                <span class="help-inline" ng-show="frmTaskForm[prop.language[0].pivot.form_field_name].$touched && frmTaskForm[prop.language[0].pivot.form_field_name].$invalid">
                                                                                    <span ng-show="frmTaskForm[prop.language[0].pivot.form_field_name].$error.required">[[prop.language[0].pivot.name]] is required.</span>
                                                                                </span>
                                            </div>

                                            <div class="col-sm-9" ng-switch-when="textbox">
                                                                        <textarea rows="4" cols="50" name="[[prop.language[0].pivot.form_field_name]]" ng-model="prop.fields[prop.language[0].pivot.form_field_name+'-'+prop.id]" maxlength="[[prop.form_field_size]]">

                                                                        </textarea>
                                                <span class="help-inline" ng-show="frmTaskForm[prop.language[0].pivot.form_field_name].$touched && frmTaskForm[prop.language[0].pivot.form_field_name].$invalid">
                                                                                    <span ng-show="frmTaskForm[prop.language[0].pivot.form_field_name].$error.required">[[prop.language[0].pivot.name]] is required.</span>
                                                                                </span>
                                            </div>
                                        </div>

                                        <div class="form-group" ng-switch-when="bool" ng-switch="prop.form_field_type">
                                            <label for="inputName" class="col-sm-3 control-label">[[prop.language[0].pivot.name]]</label>
                                            <div class="col-sm-9" ng-switch-when="radio">
                                                <label for="" class="radio-inline state">
                                                    <input type="radio" name="[[prop.language[0].pivot.form_field_name]]" value="1" ng-model="prop.fields[prop.language[0].pivot.form_field_name+'-'+prop.id]" ng-required="prop.mandatory">True
                                                </label>
                                                <label for="" class="radio-inline state">
                                                    <input type="radio" name="[[prop.language[0].pivot.form_field_name]]" value="0" ng-model="prop.fields[prop.language[0].pivot.form_field_name+'-'+prop.id]" ng-required="prop.mandatory">False
                                                </label>
                                                <span class="help-inline" ng-show="frmTaskForm[prop.language[0].pivot.form_field_name].$touched && frmTaskForm[prop.language[0].pivot.form_field_name].$invalid">
                                                                                    <span ng-show="frmTaskForm[prop.language[0].pivot.form_field_name].$error.required">[[prop.language[0].pivot.name]] is required.</span>
                                                                                </span>
                                            </div>

                                            <div class="col-sm-9" ng-switch-when="selectbox">
                                                <select class="form-control" ng-model="prop.fields[prop.language[0].pivot.form_field_name+'-'+prop.id]" ng-options="item.id as item.language[0].pivot.name for item in prop.prop_allowed_values" ng-required="prop.mandatory"> <!--arranjar-->
                                                    <option value=""></option>
                                                </select>
                                                <span class="help-inline" ng-show="frmTaskForm[prop.language[0].pivot.form_field_name].$touched && frmTaskForm[prop.language[0].pivot.form_field_name].$invalid">
                                                                                    <span ng-show="frmTaskForm[prop.language[0].pivot.form_field_name].$error.required">[[prop.language[0].pivot.name]] is required.</span>
                                                                                </span>
                                            </div>
                                        </div>

                                        <div class="form-group" ng-switch-when="enum" ng-switch="prop.form_field_type">
                                            <label for="inputName" class="col-sm-3 control-label">[[prop.language[0].pivot.name]]</label>
                                            <div class="col-sm-9" ng-switch-when="radio|checkbox" ng-switch-when-separator="|">
                                                <label for="" class="radio-inline state">
                                                    <input ng-repeat="p_a_v in prop.prop_allowed_values" type="[[prop.form_field_type]]" name="[[prop.language[0].pivot.form_field_name]]" value="[[p_a_v.id]]" ng-model="prop.fields[prop.language[0].pivot.form_field_name+'-'+prop.id]" ng-required="prop.mandatory">[[p_a_v.language[0].pivot.name]]
                                                </label>
                                                <span class="help-inline" ng-show="frmTaskForm[prop.language[0].pivot.form_field_name].$touched && frmTaskForm[prop.language[0].pivot.form_field_name].$invalid">
                                                                                    <span ng-show="frmTaskForm[prop.language[0].pivot.form_field_name].$error.required">[[prop.language[0].pivot.name]] is required.</span>
                                                                                </span>
                                            </div>

                                            <div class="col-sm-9" ng-switch-when="selectbox">
                                                <select class="form-control" name="[[prop.language[0].pivot.form_field_name]]" ng-model="prop.fields[prop.language[0].pivot.form_field_name+'-'+prop.id]" ng-options="item.id as item.language[0].pivot.name for item in prop.prop_allowed_values" ng-required="prop.mandatory">
                                                    <option value=""></option>
                                                </select>
                                                <span class="help-inline" ng-show="frmTaskForm[prop.language[0].pivot.form_field_name].$touched && frmTaskForm[prop.language[0].pivot.form_field_name].$invalid">
                                                                                    <span ng-show="frmTaskForm[prop.language[0].pivot.form_field_name].$error.required">[[prop.language[0].pivot.name]] is required.</span>
                                                                                </span>
                                            </div>
                                        </div>

                                        <div class="form-group" ng-switch-when="ent_ref">
                                            <label for="inputName" class="col-sm-3 control-label">[[prop.language[0].pivot.name]]</label>
                                            <div class="col-sm-9">
                                                <select class="form-control" name="[[prop.language[0].pivot.form_field_name]]" ng-model="prop.fields[prop.language[0].pivot.form_field_name+'-'+prop.id]" ng-options="item.id as item.language[0].pivot.name for item in prop.fk_ent_type.entity" ng-required="prop.mandatory">
                                                    <option value=""></option>
                                                </select>
                                                <span class="help-inline" ng-show="frmTaskForm[prop.language[0].pivot.form_field_name].$touched && frmTaskForm[prop.language[0].pivot.form_field_name].$invalid">
                                                                                    <span ng-show="frmTaskForm[prop.language[0].pivot.form_field_name].$error.required">[[prop.language[0].pivot.name]] is required.</span>
                                                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </form>
