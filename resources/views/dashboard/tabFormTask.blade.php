                                indextab:[[indexTab]]
                                <div class="panel panel-info">
                                    <div class="panel-heading">
                                        <h3 class="panel-title" ng-if="::modal_formTab.tab[indexTab].relTypeExist==false">[[::modal_formTab.tab[indexTab].propsform[0].ent_type.language[0].pivot.name]] [[type]]</h3>
                                        <h3 class="panel-title" ng-if="::modal_formTab.tab[indexTab].relTypeExist==true">[[::modal_formTab.tab[indexTab].propsform[0].rel_type.language[0].pivot.name]] [[type]]</h3>
                                    </div>
                                    <div class="panel-body">
                                            <div ng-if="::modal_formTab.tab[indexTab].relTypeExist==true">
                                                <div class="form-group">
                                                    <label for="inputTransactionType" class="col-sm-3 control-label">Entity 1:</label>
                                                    <div class="col-sm-9">
                                                        <ui-select ng-model="modal_formTab.tab[indexTab].entity1.selected" theme="bootstrap" ng-required="true">
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
                                                        <ui-select ng-model="modal_formTab.tab[indexTab].entity2.selected" theme="bootstrap" ng-required="true">
                                                            <ui-select-match placeholder="Select or search a process type">[[$select.selected.language[0].pivot.name]]</ui-select-match>
                                                            <ui-select-choices repeat="item in entities2 | filter: $select.search">
                                                                <div ng-bind-html="item.language[0].pivot.name | highlight: $select.search"></div>
                                                            </ui-select-choices>
                                                        </ui-select>
                                                    </div>
                                                </div>
                                            </div>



                                            <div ng-repeat="prop in ::modal_formTab.tab[indexTab].propsform" ng-switch="prop.value_type" emit-last-repeater-element>
                                                <div class="form-group" ng-switch-when="text|double|int" ng-switch-when-separator="|" ng-switch="prop.form_field_type">
                                                    <label for="inputName" class="col-sm-3 control-label">[[prop.language[0].pivot.name]]</label>
                                                    <div class="col-sm-9" ng-switch-when="text|number" ng-switch-when-separator="|">
                                                        {{--<input type="text" class="form-control" id="[[prop.language[0].pivot.form_field_name]]" name="[[prop.language[0].pivot.form_field_name]]" placeholder=""
                                                               ng-model="prop.fields[prop.language[0].pivot.form_field_name+'-'+prop.id]" maxlength="[[prop.form_field_size]]" ng-required="prop.mandatory">
                                                        --}}<input type="[[prop.form_field_type]]" class="form-control" id="[[prop.language[0].pivot.form_field_name]]" name="[[prop.language[0].pivot.form_field_name]]" placeholder=""
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

                                                    <br>
                                                    <br>
                                                    <div class="row" ng-if="prop.PropertiesInfo!=null || prop.PropertiesInfoEntType!=null">
                                                    <div class="col-sm-9 col-centered">
                                                    <uib-accordion close-others="oneAtATime">
                                                        <div uib-accordion-group class="panel-default" is-open="status.open">
                                                            <uib-accordion-heading>
                                                                Other transactions information <i class="pull-right glyphicon" ng-class="{'glyphicon-chevron-down': status.open, 'glyphicon-chevron-right': !status.open}"></i>
                                                            </uib-accordion-heading>
                                                            <div ng-include="dynamicPopover.templateUrl"></div>

                                                        </div>
                                                    </uib-accordion>
                                                    </div>
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
                                                    <div class="col-sm-9" ng-switch-when="radio">
                                                        <label for="" ng-repeat="p_a_v in prop.prop_allowed_values" class="radio-inline state">
                                                            <input type="[[prop.form_field_type]]" name="[[prop.language[0].pivot.form_field_name]]" value="[[p_a_v.id]]" ng-model="prop.fields[prop.language[0].pivot.form_field_name+'-'+prop.id]" ng-required="prop.mandatory">[[p_a_v.language[0].pivot.name]]
                                                        </label>
                                                        <span class="help-inline" ng-show="frmTaskForm[prop.language[0].pivot.form_field_name].$touched && frmTaskForm[prop.language[0].pivot.form_field_name].$invalid">
                                                            <span ng-show="frmTaskForm[prop.language[0].pivot.form_field_name].$error.required">[[prop.language[0].pivot.name]] is required.</span>
                                                        </span>
                                                    </div>

                                                    <div class="col-sm-9" ng-switch-when="checkbox">
                                                        [[prop.fields]]
                                                        <label for="" ng-repeat="p_a_v in prop.prop_allowed_values" ng-if="prop.mandatory" class="radio-inline state">
                                                            {{--<input type="[[prop.form_field_type]]" name="[[prop.language[0].pivot.form_field_name]]" value="[[p_a_v.id]]" ng-model="prop.fields[prop.language[0].pivot.form_field_name+'-'+prop.id+'-'+p_a_v.id]" ng-click="updateQuestionValue(prop.language[0].pivot.form_field_name+'-'+prop.id+'-'+p_a_v.id, prop.id)" ng-checked="value.indexOf(prop.language[0].pivot.form_field_name+'-'+prop.id+'-'+p_a_v.id) > -1" ng-required="value.length == 0">[[p_a_v.language[0].pivot.name]]--}}
                                                            <input type="[[prop.form_field_type]]" name="[[prop.language[0].pivot.form_field_name]]" value="[[p_a_v.id]]" ng-model="prop.fields[prop.language[0].pivot.form_field_name+'-'+prop.id+'-'+p_a_v.id]" ng-click="updateValue(prop.language[0].pivot.form_field_name+'-'+prop.id+'-'+p_a_v.id, $parent.$parent.$index, indexTab)" ng-required="prop.fields === undefined">[[p_a_v.language[0].pivot.name]]
                                                        </label>
                                                        <label for="" ng-repeat="p_a_v in prop.prop_allowed_values" ng-if="!prop.mandatory" class="radio-inline state">
                                                            <input type="[[prop.form_field_type]]" name="[[prop.language[0].pivot.form_field_name]]" value="[[p_a_v.id]]" ng-model="prop.fields[prop.language[0].pivot.form_field_name+'-'+prop.id+'-'+p_a_v.id]">[[p_a_v.language[0].pivot.name]]
                                                        </label>
                                                        <span class="help-inline" ng-show="frmTaskForm[prop.language[0].pivot.form_field_name].$touched && frmTaskForm[prop.language[0].pivot.form_field_name].$invalid">
                                                            <span ng-show="frmTaskForm[prop.language[0].pivot.form_field_name].$error.required">[[prop.language[0].pivot.name]] is required.</span>
                                                        </span>
                                                    </div>

                                                    <div class="col-sm-9" ng-switch-when="selectbox">
                                                        <select class="form-control" name="[[prop.language[0].pivot.form_field_name]]" ng-model="prop.fields[prop.language[0].pivot.form_field_name+'-'+prop.id]" ng-if="prop.has_entType=='true'" ng-change="verParEntType(prop.fields[prop.language[0].pivot.form_field_name+'-'+prop.id], indexTab)" ng-options="item.id as item.language[0].pivot.name for item in prop.prop_allowed_values" ng-required="prop.mandatory">
                                                            <option value=""></option>
                                                        </select>
                                                        <select class="form-control" name="[[prop.language[0].pivot.form_field_name]]" ng-model="prop.fields[prop.language[0].pivot.form_field_name+'-'+prop.id]" ng-if="prop.has_entType=='false'" ng-options="item.id as item.language[0].pivot.name for item in prop.prop_allowed_values" ng-required="prop.mandatory">
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

                                                <div class="form-group" ng-switch-when="prop_ref">
                                                    <label for="inputName" class="col-sm-3 control-label">[[prop.language[0].pivot.name]]</label>
                                                    <div class="col-sm-9">
                                                        <select class="form-control" name="[[prop.language[0].pivot.form_field_name]]" ng-model="prop.fields[prop.language[0].pivot.form_field_name+'-'+prop.id]" ng-options="item.id as item.value for item in prop.fk_property.values" ng-required="prop.mandatory">
                                                            <option value=""></option>
                                                        </select>
                                                        <span class="help-inline" ng-show="frmTaskForm[prop.language[0].pivot.form_field_name].$touched && frmTaskForm[prop.language[0].pivot.form_field_name].$invalid">
                                                            <span ng-show="frmTaskForm[prop.language[0].pivot.form_field_name].$error.required">[[prop.language[0].pivot.name]] is required.</span>
                                                        </span>
                                                    </div>
                                                </div>

                                                {{-- Inicio alterações Guilherme --}}
                                                <div class="form-group" ng-switch-when="file">
                                                    <label for="inputName" class="col-sm-3 control-label">[[prop.language[0].pivot.name]]</label>
                                                    <div class="col-sm-9" >
                                                        <input type="file" class="form-control" id="[[prop.language[0].pivot.form_field_name]]" ng-model="files[prop.language[0].pivot.form_field_name]" nv-file-select="" ng-disabled="files[prop.language[0].pivot.form_field_name]!=null" ng-required="prop.mandatory" uploader="uploader" valid-file />
                                                    </div>
                                                </div>

                                                {{-- Fim alterações Guilherme --}}
                                            </div>

                                            <div ng-if="modal_formTab.tab[indexTab].showMessage">
                                                <div ng-include="templatePath" onload="propsform_=myPropsform_;relTypeExist_=myRelTypeExist_"></div>
                                            </div>

                                        <br>
                                        <br>
                                        {{-- Inicio alterações Guilherme --}}
                                        {{--<div class="col-sm-9" style="margin-bottom: 40px" ng-if="fileExist">--}}
                                        <div class="col-sm-9 center-block" style="margin-bottom: 20px" ng-if="::modal_formTab.tab[indexTab].fileExist">

                                            <h3>{{trans("dashboard/modalFormTask.HEADER3")}}</h3>
                                            <p>{{trans("dashboard/modalFormTask.LENGTHSIZE")}}: [[ uploader.queue.length ]]</p>

                                            <table class="table">
                                                <thead>
                                                <tr>
                                                    <th width="50%">{{trans("dashboard/modalFormTask.THEADERNAME")}}</th>
                                                    <th ng-show="uploader.isHTML5">{{trans("dashboard/modalFormTask.THEADERSIZE")}}</th>
                                                    <th ng-show="uploader.isHTML5">{{trans("dashboard/modalFormTask.THEADERPROGRESS")}}</th>
                                                    <th>{{trans("dashboard/modalFormTask.THEADERSTATUS")}}</th>
                                                    <th>{{trans("dashboard/modalFormTask.THEADERACTION")}}</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr ng-repeat="item in uploader.queue">
                                                    <td><strong>[[ item.file.name ]]</strong></td>
                                                    <td ng-show="uploader.isHTML5" nowrap>[[ item.file.size/1024/1024|number:2 ]] MB</td>
                                                    <td ng-show="uploader.isHTML5">
                                                        <div class="progress" style="margin-bottom: 0;">
                                                            <div class="progress-bar" role="progressbar" ng-style="{ 'width': item.progress + '%' }"></div>
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <span ng-show="item.isSuccess"><i class="glyphicon glyphicon-ok"></i></span>
                                                        <span ng-show="item.isCancel"><i class="glyphicon glyphicon-ban-circle"></i></span>
                                                        <span ng-show="item.isError"><i class="glyphicon glyphicon-remove"></i></span>
                                                    </td>
                                                    <td nowrap>
                                                        <button type="button" class="btn btn-danger btn-xs" ng-click="item.remove()">
                                                            <span class="glyphicon glyphicon-trash"></span> Remove
                                                        </button>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>

                                            <div>
                                                <div>
                                                    Queue progress:
                                                    <div class="progress" style="">
                                                        <div class="progress-bar" role="progressbar" ng-style="{ 'width': uploader.progress + '%' }"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- Fim alterações Guilherme --}}
                                    </div>
                                </div>

                                {{--<div growl reference="[]">
                                </div>--}}
                                <div ng-if="::modal_formTab.tab[indexTab].showBtnType==true">
                                    {{--<button type="button" class="btn btn-default btn-blue" ng-click="changeTabBoot(trans_id, 'Task Form', 'tabFormTask', tabnumber, type)">Next</button>--}}
                                </div>
                                <div ng-if="::modal_formTab.tab[indexTab].showBtnType==false">
                                    <button type="button" class="btn btn-default btn-blue" ng-click="changeTabBoot('Task Form', 'tabFormTask', indexTab, type)">Next</button>
                                </div>