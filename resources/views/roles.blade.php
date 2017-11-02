@extends('layouts.default')
@section('content')

    <h2>[[ "PHEADER" | translate]]</h2>
    <div ng-controller="rolesController">
        <div growl></div>

        <button class="btn btn-default btn-xs btn-detail" ng-click="dotranslate()">[[ "BTN1" | translate]]</button>

        <!-- Table-to-load-the-data Part -->
        <table class="table" ng-init="getRoles()">


            <thead>
            <form ng-submit="filter()">
                <tr>

                    <th><input type="text" ng-model="search_id" class="form-control" placeholder='[[ "THEADER1" | translate]]'></th>
                    <th><input type="text" ng-model="search_name" class="form-control" placeholder='[[ "THEADER2" | translate]]'></th>
                    <th><input type="text" ng-model="search_updated_at" class="form-control" placeholder='[[ "THEADER3" | translate]]'></th>
                    <th><input type='[[ "BTN8" | translate]]' /></th>
                    <th></th>
                    <th></th>
                </tr>
            </form>
            <tr>
                <th>[[ "THEADER1" | translate]]<button class="btn btn-default btn-xs btn-detail" ng-click="sort('role.id',1)"><i ng-if="num == 1" class="[[type_class]]"></i><i ng-if="num != 1" class="fa fa-fw fa-sort"></i></button></th>
                <th>[[ "THEADER2" | translate]]<button class="btn btn-default btn-xs btn-detail" ng-click="sort('role_name.name',2)"><i ng-if="num == 2" class="[[type_class]]"></i><i ng-if="num != 2" class="fa fa-fw fa-sort"></i></button></th>
                <th>[[ "THEADER3" | translate]]<button class="btn btn-default btn-xs btn-detail" ng-click="sort('role.updated_at',3)"><i ng-if="num == 3" class="[[type_class]]"></i><i ng-if="num != 3" class="fa fa-fw fa-sort"></i></button></th>
                <th>[[ "THEADER4" | translate]]</th>
                <th>[[ "THEADER5" | translate]]</th>
                <th><button id="btn-add" class="btn btn-success btn-xs" ng-click="toggle('add', 0)">[[ "BTN2" | translate]]</button></th>
            </tr>
            </thead>
            <tbody>
            <tr ng-repeat="role in roles">

                <td>[[ role.id ]]</td>
                <td>[[ role.name]]</td>
                <td>[[ role.updated_at]]</td>
                <td>
                    <button class="btn btn-success btn-xs btn-detail" ng-click="toggle('add_actors', role.id)">[[ "BTN3" | translate]]</button>
                    <button class="btn btn-primary btn-xs btn-detail" ng-click="toggle('view_actors', role.id)">[[ "BTN4" | translate]]</button>
                </td>
                <td>
                    <button class="btn btn-success btn-xs btn-detail" ng-click="toggle('add_users', role.id)">[[ "BTN15" | translate]]</button>
                    <button class="btn btn-primary btn-xs btn-detail" ng-click="toggle('view_users', role.id)">[[ "BTN16" | translate]]</button>
                </td>
                <td>
                    <button class="btn btn-warning btn-xs btn-detail" ng-click="toggle('edit', role.id)">[[ "BTN5" | translate]]</button>
                    <button class="btn btn-danger btn-xs btn-delete" ng-click="toggle('remove', role.id)">[[ "BTN6" | translate]]</button>
                    {{--<button class="btn btn-primary btn-xs btn-delete">History</button>--}}
                </td>
            </tr>
            </tbody>
        </table>
        <div>
            <posts-pagination></posts-pagination>
        </div>
        <!-- End of Table-to-load-the-data Part -->
        <!-- Modal (Pop up when detail button clicked) -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <div ng-switch on="modalstate">
                            <div ng-switch-when="view_actors">
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

                            <div ng-switch-when="view_users">
                                <h4 class="modal-title" id="myModalLabel">[[ "MHEADER5" | translate]]</h4>
                            </div>

                            <div ng-switch-when="add_actors">
                                <h4 class="modal-title" id="myModalLabel">[[ "MHEADER6" | translate]]</h4>
                            </div>

                            <div ng-switch-when="add_users">
                                <h4 class="modal-title" id="myModalLabel">[[ "MHEADER7" | translate]]</h4>
                            </div>

                            <div ng-switch-default>
                                <h4 class="modal-title" id="myModalLabel">[[form_title]]</h4>
                            </div>
                        </div>

                    </div>

                    <div class="modal-body">
                        <div ng-switch on="modalstate">

                            <div ng-switch-when="add_actors">
                                <form name="frmUnitTypes" class="form-horizontal" novalidate="">
                                    <div class="form-group">
                                        <label class="col-sm-12 control-label" style="text-align: center">[[ "LBL1" | translate]] [[ role.name]]</label>
                                        <div class="col-sm-12">
                                            <label>[[ "LBL2" | translate]]</label>
                                            <ui-select multiple ng-model="selactors.selected" theme="bootstrap" style="width: 100%"
                                                       sortable="true" close-on-select="false" title="Choose an Actor">
                                                <ui-select-match placeholder="Actors...">[[$item.name]] (Id:[[$item.id]])</ui-select-match>
                                                <ui-select-choices repeat="actor in actors | propsFilter: {name: $select.search, id: $select.search}">
                                                    {{--[[role.name]] (id:[[role.id]])--}}
                                                    <div ng-bind-html="actor.name | highlight: $select.search"></div>
                                                    (Id:<span ng-bind-html="actor.id | highlight: $select.search"></span>)

                                                </ui-select-choices>
                                            </ui-select>
                                            {{--<p>Selected: [[selactors.selected]]</p>--}}
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div ng-switch-when="add_users">
                                <form name="frmUnitTypes" class="form-horizontal" novalidate="">
                                    <div class="form-group">
                                        <label class="col-sm-12 control-label" style="text-align: center">[[ "LBL5" | translate]] [[ role.name]]</label>
                                        <div class="col-sm-12">
                                            <label>[[ "LBL6" | translate]]</label>
                                            {{--<script type="text/javascript">--}}
                                                {{--$(".userselecting").select2({--}}
                                                    {{--placeholder: "Users Roles",--}}
                                                    {{--allowClear: true--}}
                                                {{--});--}}
                                            {{--</script>--}}
                                            {{--<select class="userselecting" style="width: 100%" multiple="multiple" id="userselect" name="userselect" ng-model="selusers" ng-options="user.id as user.name for user in users" required>--}}
                                            {{--</select>--}}

                                            <ui-select multiple ng-model="selusers.selected" theme="bootstrap" style="width: 100%"
                                                       sortable="true" close-on-select="false" title="Choose a User">
                                                <ui-select-match placeholder="Users...">[[$item.name]] (Id:[[$item.id]])</ui-select-match>
                                                <ui-select-choices repeat="user in users | propsFilter: {name: $select.search, id: $select.search}">
                                                    <div ng-bind-html="user.name | highlight: $select.search"></div>
                                                    (Id:<span ng-bind-html="user.id | highlight: $select.search"></span>)
                                                </ui-select-choices>
                                            </ui-select>
                                            {{--<p>Selected: [[selactors.selected]]</p>--}}
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div ng-switch-when="view_actors">
                                <form name="frmUnitTypes" class="form-horizontal" novalidate="">
                                    <div class="form-group">
                                        <label class="col-sm-12 control-label" style="text-align: center">[[ role.name]]</label>
                                        <label class="col-sm-12 control-label" style="text-align: left">[[ "LBL3" | translate]]</label>
                                        <div class="col-sm-12">
                                            <table class="table" ng-init="selactors">
                                                <thead>
                                                <tr>
                                                    <th>[[ "T2HEADER1" | translate]]</th>
                                                    <th>[[ "T2HEADER2" | translate]]</th>
                                                    <th>[[ "T2HEADER3" | translate]]</th>
                                                    <th><button class="btn btn-success btn-xs btn-detail" ng-click="toggle('add_actors', role.id)">[[ "BTN9" | translate]]</button></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr ng-repeat="selactor in selactors">
                                                    <td>[[ selactor.id ]]</td>
                                                    <td>[[ selactor.name ]]</td>
                                                    <td>[[ selactor.updated_at]]</td>
                                                    <td>
                                                        <button class="btn btn-danger btn-xs btn-delete" id="btn-delete" ng-click="removeactor(role.id,selactor.id)" ng-disabled="frmUnitTypes.$invalid">[[ "BTN10" | translate]]</button>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div ng-switch-when="view_users">
                                <form name="frmUnitTypes" class="form-horizontal" novalidate="">
                                    <div class="form-group">
                                        <label class="col-sm-12 control-label" style="text-align: center">[[ role.name]]</label>
                                        <label class="col-sm-12 control-label" style="text-align: left">[[ "LBL7" | translate]]</label>
                                        <div class="col-sm-12">
                                            <table class="table" ng-init="selusers">
                                                <thead>
                                                <tr>
                                                    <th>[[ "T2HEADER1" | translate]]</th>
                                                    <th>[[ "T2HEADER2" | translate]]</th>
                                                    <th>[[ "T2HEADER3" | translate]]</th>
                                                    <th><button class="btn btn-success btn-xs btn-detail" ng-click="toggle('add_users', role.id)">[[ "BTN17" | translate]]</button></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr ng-repeat="seluser in selusers">
                                                    <td>[[ seluser.id ]]</td>
                                                    <td>[[ seluser.name ]]</td>
                                                    <td>[[ seluser.updated_at]]</td>
                                                    <td>
                                                        <button class="btn btn-danger btn-xs btn-delete" id="btn-delete" ng-click="removeuser(role.id,seluser.id)" ng-disabled="frmUnitTypes.$invalid">[[ "BTN10" | translate]]</button>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </form>
                            </div>




                            <div ng-switch-default>
                                <form name="frmUnitTypes" class="form-horizontal" novalidate="">

                                    <div class="form-group">
                                        <label for="inputName" class="col-sm-3 control-label">[[ "LBL4" | translate]]</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="role_name" name="role_name" placeholder="" value="@]]name]]"
                                                   ng-model="role.name" ng-required="true">
                                            <span class="help-inline"
                                                  ng-show="frmUnitTypes.contact_number.$invalid && frmUnitTypes.prop_unit_type_name.$touched">[[ "WRNG1" | translate]]</span>
                                        </div>
                                    </div>
                                </form>
                            </div>


                        </div>
                    </div>

                    <div ng-switch on="modalstate">
                        <div ng-switch-when="view_actors">
                        </div>
                        <div ng-switch-when="view_users">
                        </div>

                        <div ng-switch-when="add">
                            <div class="modal-footer">
                            <button type="button" class="btn btn-primary" id="btn-save" ng-click="save(modalstate, id)" ng-disabled="frmUnitTypes.$invalid">[[ "BTN11" | translate]]</button>
                            </div>
                            </div>

                        <div ng-switch-when="edit">
                            <div class="modal-footer">
                            <button type="button" class="btn btn-primary" id="btn-save" ng-click="save(modalstate, id)" ng-disabled="frmUnitTypes.$invalid">[[ "BTN12" | translate]]</button>
                            </div>
                            </div>

                        <div ng-switch-when="remove">
                            <div class="modal-footer">
                            <button type="button" class="btn btn-primary" id="btn-save" ng-click="save(modalstate, id)" ng-disabled="frmUnitTypes.$invalid">[[ "BTN13" | translate]]</button>
                            </div>
                        </div>

                        <div ng-switch-when="add_actors">
                            <div class="modal-footer">
                            <button type="button" class="btn btn-primary" id="btn-save" ng-click="save(modalstate, id)" ng-disabled="frmUnitTypes.$invalid">[[ "BTN14" | translate]]</button>
                            </div>
                            </div>

                        <div ng-switch-when="add_users">
                            <div class="modal-footer">
                            <button type="button" class="btn btn-primary" id="btn-save" ng-click="save(modalstate, id)" ng-disabled="frmUnitTypes.$invalid">[[ "BTN18" | translate]]</button>
                            </div>
                        </div>

                        <div ng-switch-default>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" id="btn-save" ng-click="save(modalstate, id)" ng-disabled="frmUnitTypes.$invalid">[[btn_label]]</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('footerContent')
    <script src="<?= asset('app/controllers/roles.js') ?>"></script>
@stop