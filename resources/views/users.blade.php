@extends('layouts.default')
@section('content')
    <h2>[[ "PHEADER" | translate]]</h2>
    <div ng-controller="usersController">
        <div growl></div>

        <button class="btn btn-default btn-xs btn-detail" ng-click="dotranslate()">[[ "BTN1" | translate]]</button>

        <table class="table" ng-init="getUsers()">
            <thead>
            <form ng-submit="filter()">
                <tr>

                    <th><input type="text" ng-model="search_id" class="form-control" placeholder='[[ "THEADER1" | translate]]'></th>
                    <th><input type="text" ng-model="search_name" class="form-control" placeholder='[[ "THEADER2" | translate]]'></th>
                    <th><input type="text" ng-model="search_email" class="form-control" placeholder='[[ "THEADER5" | translate]]'></th>
                    <th><input type="text" ng-model="search_user_name" class="form-control" placeholder='[[ "THEADER6" | translate]]'></th>
                    <th><input type="text" ng-model="search_languageslug" class="form-control" placeholder='[[ "THEADER7" | translate]]'></th>
                    <th><input type="text" ng-model="search_user_type" class="form-control" placeholder='[[ "THEADER8" | translate]]'></th>
                    <th><input type="text" ng-model="search_entity" class="form-control" placeholder='[[ "THEADER9" | translate]]'></th>
                    <th><input type="text" ng-model="search_updated_at" class="form-control" placeholder='[[ "THEADER3" | translate]]'></th>
                    <th><input type="submit" value='[[ "BTN8" | translate]]'/></th>
                </tr>
            </form>
            <tr>
                <th>[[ "THEADER1" | translate]]<button class="btn btn-default btn-xs btn-detail" ng-click="sort('users.id',1)"><i ng-if="num == 1" class="[[type_class]]"></i><i ng-if="num != 1" class="fa fa-fw fa-sort"></i></button></th>
                <th>[[ "THEADER2" | translate]]<button class="btn btn-default btn-xs btn-detail" ng-click="sort('users.name',2)"><i ng-if="num == 2" class="[[type_class]]"></i><i ng-if="num != 2" class="fa fa-fw fa-sort"></i></button></th>
                <th>[[ "THEADER5" | translate]]<button class="btn btn-default btn-xs btn-detail" ng-click="sort('users.email',3)"><i ng-if="num == 3" class="[[type_class]]"></i><i ng-if="num != 3" class="fa fa-fw fa-sort"></i></button></th>
                <th>[[ "THEADER6" | translate]]<button class="btn btn-default btn-xs btn-detail" ng-click="sort('users.user_name',4)"><i ng-if="num == 4" class="[[type_class]]"></i><i ng-if="num != 4" class="fa fa-fw fa-sort"></i></button></th>
                <th>[[ "THEADER7" | translate]]<button class="btn btn-default btn-xs btn-detail" ng-click="sort('languageslug',5)"><i ng-if="num == 5" class="[[type_class]]"></i><i ng-if="num != 5" class="fa fa-fw fa-sort"></i></button></th>
                <th>[[ "THEADER8" | translate]]<button class="btn btn-default btn-xs btn-detail" ng-click="sort('users.user_type',6)"><i ng-if="num == 6" class="[[type_class]]"></i><i ng-if="num != 6" class="fa fa-fw fa-sort"></i></button></th>
                <th>[[ "THEADER9" | translate]]<button class="btn btn-default btn-xs btn-detail" ng-click="sort('selentity',7)"><i ng-if="num == 7" class="[[type_class]]"></i><i ng-if="num != 7" class="fa fa-fw fa-sort"></i></button></th>
                <th>[[ "THEADER3" | translate]]<button class="btn btn-default btn-xs btn-detail" ng-click="sort('users.updated_at',8)"><i ng-if="num == 8" class="[[type_class]]"></i><i ng-if="num != 8" class="fa fa-fw fa-sort"></i></button></th>
                <th>[[ "THEADER4" | translate]]</th>
                <th><button id="btn-add" class="btn btn-success btn-xs" ng-click="toggle('add', 0)">[[ "BTN2" | translate]]</button></th>
            </tr>
            </thead>
            <tbody>
            <tr ng-repeat="user in users">

                <td>[[ user.id ]]</td>
                <td>[[ user.name]]</td>
                <td>[[ user.email]]</td>
                <td>[[ user.user_name]]</td>
                <td>[[ user.languageslug]]</td>
                <td>[[ user.user_type]]</td>
                <td>[[ user.selentity]]</td>
                <td>[[ user.updated_at]]</td>
                <td>
                    <button class="btn btn-success btn-xs btn-detail" ng-click="toggle('add_roles', user.id)">[[ "BTN3" | translate]]</button>
                    <button class="btn btn-primary btn-xs btn-detail" ng-click="toggle('view_roles', user.id)">[[ "BTN4" | translate]]</button>
                </td>
                <td>
                    <button class="btn btn-warning btn-xs btn-detail" ng-click="toggle('edit', user.id)">[[ "BTN5" | translate]]</button>
                    <button class="btn btn-danger btn-xs btn-delete" ng-click="toggle('remove', user.id)">[[ "BTN6" | translate]]</button>
                    {{--<button class="btn btn-primary btn-xs btn-delete">History</button>--}}
                </td>
            </tr>
            </tbody>
        </table>
        <div>
            <posts-pagination></posts-pagination>
        </div>


        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>

                        <div ng-switch on="modalstate">
                            <div ng-switch-when="view_roles">
                                <h4 class="modal-title" id="myModalLabel">[[ "MHEADER4" | translate]]</h4>
                            </div>

                            <div ng-switch-when="add">
                                <h4 class="modal-title" id="myModalLabel">[[ "MHEADER1" | translate]]</h4>
                            </div>

                            <div ng-switch-when="edit">
                                <h4 class="modal-title" id="myModalLabel">[[ "MHEADER2" | translate]]</h4>
                            </div>

                            <div ng-switch-when="remove">
                                <h4 class="modal-title" id="myModalLabel">[[ "MHEADER3" | translate]]</h4>
                            </div>

                            <div ng-switch-when="add_roles">
                                <h4 class="modal-title" id="myModalLabel">[[ "MHEADER5" | translate]]</h4>
                            </div>

                            <div ng-switch-default>
                                <h4 class="modal-title" id="myModalLabel">[[form_title]]</h4>
                            </div>
                        </div>

                    </div>
                    <div class="modal-body">
                        <div ng-switch on="modalstate">

                            <div ng-switch-when="add_roles">
                                <form name="frmUnitTypes" class="form-horizontal" novalidate="">
                                    <div class="form-group">
                                        <label class="col-sm-12 control-label" style="text-align: center">[[ "LBL1" | translate]] [[ user.name]]</label>
                                        <div class="col-sm-12">
                                            <label>[[ "LBL2" | translate]]</label>
                                            <ui-select multiple ng-model="selroles.selected" theme="bootstrap" style="width: 100%"
                                                       sortable="true" close-on-select="false" title="Choose a Role">
                                                <ui-select-match placeholder="User Roles...">[[$item.name]] (Id:[[$item.id]])</ui-select-match>
                                                <ui-select-choices repeat="role in roles | propsFilter: {name: $select.search, id: $select.search}">
                                                    {{--[[role.name]] (id:[[role.id]])--}}
                                                    <div ng-bind-html="role.name | highlight: $select.search"></div>
                                                    (Id:<span ng-bind-html="role.id | highlight: $select.search"></span>)

                                                </ui-select-choices>
                                            </ui-select>
                                            {{--<p>Selected: [[selroles.selected]]</p>--}}
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div ng-switch-when="view_roles">
                                <form name="frmUnitTypes" class="form-horizontal" novalidate="">
                                    <div class="form-group">
                                        <label class="col-sm-12 control-label" style="text-align: center">[[ user.name]]</label>
                                        <label class="col-sm-12 control-label" style="text-align: left">[[ "LBL3" | translate]]</label>
                                        <div class="col-sm-12">
                                            <table class="table" ng-init="selroles">
                                                <thead>
                                                <tr>
                                                    <th>[[ "T2HEADER1" | translate]]</th>
                                                    <th>[[ "T2HEADER2" | translate]]</th>
                                                    <th>[[ "T2HEADER3" | translate]]</th>
                                                    <th><button class="btn btn-success btn-xs btn-detail" ng-click="toggle('add_roles', user.id)">[[ "BTN9" | translate]]</button></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr ng-repeat="selrole in selroles">
                                                    <td>[[ selrole.id ]]</td>
                                                    <td>[[ selrole.name ]]</td>
                                                    <td>[[ selrole.updated_at]]</td>
                                                    <td>
                                                        <button class="btn btn-danger btn-xs btn-delete" id="btn-delete" ng-click="removerole(user.id,selrole.id)" ng-disabled="frmUnitTypes.$invalid">[[ "BTN10" | translate]]</button>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </form>
                            </div>


                            <div ng-switch-default>


                        <form name="frmUsers" class="form-horizontal" novalidate="">
                            <div class="form-group">
                                <label for="inputName" class="col-sm-3 control-label">[[ "LBL4" | translate]]</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="user_name" name="user_name" placeholder="" value="@]]name]]"
                                           ng-model="user.name" ng-required="true">
                                    <span class="help-inline"
                                          ng-show="frmUsers.contact_number.$invalid && frmUsers.prop_unit_type_name.$touched">[[ "WRNG1" | translate]]</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputName" class="col-sm-3 control-label">[[ "THEADER6" | translate]]</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="user_user_name" name="user_user_name" placeholder="" value="@]]user_name]]"
                                           ng-model="user.user_name" ng-required="true">
                                    <span class="help-inline"
                                          ng-show="frmUsers.contact_number.$invalid && frmUsers.prop_unit_type_name.$touched">User Name field is required</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail" class="col-sm-3 control-label">[[ "THEADER5" | translate]]</label>
                                <div class="col-sm-9">
                                    <input type="email" class="form-control" id="user_email" name="user_email" placeholder="" value="@]]email]]"
                                           ng-model="user.email" ng-required="true">
                                    <span class="help-inline"
                                          ng-show="frmUsers.contact_number.$invalid && frmUsers.prop_unit_type_name.$touched">Email field is required</span>
                                </div>
                            </div>


                            <div ng-switch on="modalstate">
                                <div ng-switch-when="add">

                                    <div class="form-group">
                                        <label for="inputPassword" class="col-sm-3 control-label">[[ "LBL5" | translate]]</label>
                                        <div class="col-sm-9">
                                            <input ng-model='user.password' class="form-control" type="password" name='user_password' placeholder='' required>
                                            <span class="help-inline" ng-show="form.password.$error.required">
                                        Field required</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputPassword" class="col-sm-3 control-label">[[ "LBL6" | translate]]</label>
                                        <div class="col-sm-9">
                                            <input ng-model='user.password_verify' class="form-control" type="password" name='confirm_password' placeholder='' required data-password-verify="user.password">
                                            <span class="help-inline" ng-show="form.password.$error.required">
                                        Field required</span>
                                            <span class="help-inline" ng-show="frmUsers.confirm_password.$error.passwordVerify">
                                    Fields are not equal!</span>
                                        </div>

                                    </div>

                                </div>
                                <div ng-switch-when="edit">

                                    <div class="form-group">
                                        <label for="inputPassword" class="col-sm-3 control-label">[[ "LBL7" | translate]]</label>
                                        <div class="col-sm-9">
                                            <input ng-model='user.password' class="form-control" type="password" name='user_password' placeholder=''>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputPassword" class="col-sm-3 control-label">[[ "LBL8" | translate]]</label>
                                        <div class="col-sm-9">
                                            <input ng-model='user.password_verify' class="form-control" type="password" name='confirm_password' placeholder='' ng-required='user.password' data-password-verify="user.password">
                                            <span class="help-inline" ng-show="frmUsers.confirm_password.$error.passwordVerify">
                                    Fields are not equal!</span>
                                        </div>

                                    </div>

                                </div>
                                {{--<div  ng-switch-when="remove"></div>--}}
                                {{--<div class="animate-switch" ng-switch-default>default</div>--}}
                            </div>


                            <div class="form-group">
                                <label for="langSelect" class="col-sm-3 control-label">[[ "THEADER7" | translate]]</label>
                                {{--<div class="col-sm-9">--}}
                                {{--<select ng-model="user.language_id" ng-options="lang.id as lang.name for lang in langs" ng-init="lang = [[user.language_id]]"></select>--}}
                                {{--</div>--}}
                                <div class="col-sm-9">
                                    <select class="form-control" name="languageselect" ng-model="user.language_id" ng-options="lang.id as lang.name for lang in langs" required>
                                        <option value="">[[ "LBL9" | translate]]</option>
                                    </select>
                                    <div ng-messages="frmUsers.languageselect.$error" ng-show="frmUsers.languageselect.$invalid && frmUsers.languageselect.$touched">
                                        <p ng-message="required">Selecting a Language is mandatory.</p>
                                    </div>
                                </div>
                                <br>
                                <ul ng-repeat="error in errors">
                                    <li>[[ error[0] ]]</li>
                                </ul>
                            </div>


                            <div class="form-group">
                                <label for="inputUsertype" class="col-sm-3 control-label">[[ "THEADER8" | translate]] :</label>
                                <div class="col-sm-9">
                                    <label for="" class="radio-inline state">
                                        <input type="radio" name="user_type" value="internal" ng-model="user.user_type" required>[[ "LBL10" | translate]]
                                    </label>
                                    <label for="" class="radio-inline state">
                                        <input type="radio" name="user_type" value="external" ng-model="user.user_type" required>[[ "LBL11" | translate]]
                                    </label>
                                    <span class="help-inline"
                                          ng-show="frmUsers.position.$invalid && frmUsers.position.$touched">User Type field is required</span>
                                </div>
                            </div>

                            <div ng-switch on="user.user_type">
                                <div ng-switch-when="external">
                                    <div class="form-group">
                                        <label for="entitiesSelect" class="col-sm-3 control-label">[[ "THEADER9" | translate]]</label>
                                        <div class="col-sm-9">
                                            {{--<select ng-model="user.entity_id" ng-options="entity.id as entity.name for entity in entities" ng-init="entity = [[user.entity_id]]"></select>--}}
                                            {{--</div>--}}

                                            <select class="form-control" name="entityselect" ng-model="user.entity_id" ng-options="entity.id as entity.name for entity in entities" required>
                                                <option value="">[[ "LBL12" | translate]]</option>
                                            </select>
                                            <div ng-messages="frmUsers.entityselect.$error" ng-show="frmUsers.entityselect.$invalid && frmUsers.entityselect.$touched">
                                                <p ng-message="required">Providing a process type is mandatory.</p>
                                            </div>
                                        </div>
                                        <br>
                                        <ul ng-repeat="error in errors">
                                            <li>[[ error[0] ]]</li>
                                        </ul>

                                    </div>
                                </div>

                            </div>
                        </form>
                            </div>
                    </div>
                    </div>
                    <div ng-switch on="modalstate">
                        <div ng-switch-when="view_roles">
                        </div>

                        <div ng-switch-when="add">
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" id="btn-save" ng-click="save(modalstate, id)" ng-disabled="frmUsers.$invalid">[[ "BTN11" | translate]]</button>
                            </div>
                        </div>

                        <div ng-switch-when="edit">
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" id="btn-save" ng-click="save(modalstate, id)" ng-disabled="frmUsers.$invalid">[[ "BTN12" | translate]]</button>
                            </div>
                        </div>

                        <div ng-switch-when="remove">
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" id="btn-save" ng-click="save(modalstate, id)" ng-disabled="frmUsers.$invalid">[[ "BTN13" | translate]]</button>
                            </div>
                        </div>

                        <div ng-switch-when="add_roles">
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" id="btn-save" ng-click="save(modalstate, id)" ng-disabled="frmUsers.$invalid">[[ "BTN14" | translate]]</button>
                            </div>
                        </div>

                        <div ng-switch-default>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" id="btn-save" ng-click="save(modalstate, id)" ng-disabled="frmUsers.$invalid">[[btn_label]]</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('footerContent')
    <script src="<?= asset('app/controllers/users.js') ?>"></script>

@stop