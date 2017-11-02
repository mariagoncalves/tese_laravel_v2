@extends('layouts.default')
@section('content')
    <div ng-controller="propAllowedValueController">
        <h2>[["Page_Name" | translate]]</h2>
        <div growl></div>

        <button class="btn btn-default btn-xs btn-detail" ng-click="dotranslate()">TRANSLATE</button>

        <br><br>
        <button id="btn-add" class="btn btn-primary btn-xs" ng-click="openModalForm('md', 0, 'add')">[["THEADER7" | translate]]</button>
        <br><br>

        <div class="alert alert-danger" ng-show="tableParams==null">
            [[ "EMPTY_TABLE" | translate ]] [[  "Page_Name" | translate ]]
        </div>

        <table ng-table="tableParams" class="table table-condensed table-bordered table-hover" ng-show="tableParams!=null">
            <tr class="ng-table-group" ng-repeat-start="group in $groups">
                <td colspan="1">
                    <a href="" ng-click="group.$hideRows = !group.$hideRows">
                        <span class="glyphicon" ng-class="{ 'glyphicon-chevron-right': group.$hideRows, 'glyphicon-chevron-down': !group.$hideRows }"></span>
                        <strong>[[ group.value ]]</strong>
                    </a>
                </td>
            </tr>
            <tr ng-hide="group.$hideRows" ng-repeat="prop_all_value in group.data" ng-repeat-end>
                <td sortable="'ent_name'" filter="{ent_name: 'text'}" data-title="'THEADER1' | translate" groupable="'ent_name'"> <!--Entity Type Name-->
                    [[::prop_all_value.ent_name]]
                </td>

                <td sortable="'prop_id'" filter="{prop_id: 'number'}"data-title="'THEADER2' | translate" groupable="'prop_id'"> <!--Entity Type Id-->
                    [[::prop_all_value.prop_id]]
                </td>

                <td sortable="'prop_name'" filter="{prop_name: 'text'}" data-title="'THEADER3' | translate" groupable="'prop_name'"> <!--Entity Type Name-->
                    [[::prop_all_value.prop_name]]
                </td>

                <td sortable="'prop_all_value_id'" filter="{prop_all_value_id: 'number'}" data-title="'THEADER4' | translate" ng-if="prop_all_value.prop_all_value_name == null" colspan="4"> <!--Prop Allowed Value Id-->
                    [["THEADER_EMPTY_VALUES" | translate]]
                </td>

                <td sortable="'prop_all_value_id'" filter="{prop_all_value_id: 'number'}" data-title="'THEADER4' | translate" ng-if="prop_all_value.prop_all_value_name != null"> <!--Prop Allowed Value Id-->
                    [[ ::prop_all_value.prop_all_value_id ]]
                </td>

                <td sortable="'prop_all_value_name'" data-title="'THEADER5' | translate" ng-if="prop_all_value.prop_all_value_name != null"> <!--Prop Allowed Value Name-->
                    [[ ::prop_all_value.prop_all_value_name ]]
                </td>

                <td ng-if="prop_all_value.prop_all_value_name != null">
                    <button class="btn btn-warning btn-xs btn-detail" ng-click="openModalForm('md', prop_all_value.prop_all_value_id , 'edit')">[[ "BTNTABLE1" | translate]]</button>
                    <button class="btn btn-primary btn-xs btn-delete">[[ "BTNTABLE2" | translate]]</button>
                </td>
            </tr>
        </table>
    </div>
@stop
@section('footerContent')
    <script src="<?= asset('app/controllers/propallowedvalue.js') ?>"></script>
@stop
