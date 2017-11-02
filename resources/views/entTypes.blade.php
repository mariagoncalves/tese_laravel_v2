@extends('layouts.default')
@section('content')
    <div ng-controller="entityTypesController">
        <h2>[["Page_Name" | translate]]</h2>
        <div growl></div>

        <button class="btn btn-default btn-xs btn-detail" ng-click="dotranslate()">TRANSLATE</button>

        <br><br>
        <button id="btn-add" class="btn btn-primary btn-xs" ng-click="openModalForm('md', 0, 'add')">[[ "THEADER11" | translate]]</button>
        <br><br>
        <div class="alert alert-danger" ng-show="tableParams==null" ng-cloak>
            [[ "EMPTY_TABLE" | translate ]] [[  "Page_Name" | translate ]]
        </div>
        <table ng-table="tableParams" class="table table-condensed table-bordered table-hover" ng-show="tableParams!=null" ng-cloak>
            <tr class="ng-table-group" ng-repeat-start="group in $groups">
                <td colspan="1">
                    <a href="" ng-click="group.$hideRows = !group.$hideRows">
                        <span class="glyphicon" ng-class="{ 'glyphicon-chevron-right': group.$hideRows, 'glyphicon-chevron-down': !group.$hideRows }"></span>
                        <strong>[[ group.value ]]</strong>
                    </a>
                </td>
            </tr>
            <tr ng-hide="group.$hideRows" ng-repeat="entitytype in group.data" ng-repeat-end>
                <td sortable="'process_type_name'" filter="{process_type_name: 'text'}" data-title="'THEADER1' | translate" groupable="'process_type_name'"> <!--Process Type-->
                    [[entitytype.process_type_name]]
                </td>

                <td sortable="'transaction_type_t_name'" filter="{transaction_type_t_name: 'number'}" data-title="'THEADER2' | translate" groupable="'transaction_type_t_name'"> <!--Transaction Type-->
                    [[entitytype.transaction_type_t_name]]
                </td>

                <td sortable="'id'" filter="{id: 'number'}" data-title="'THEADER3' | translate" groupable="'id'"> <!--ID-->
                    [[entitytype.id]]
                </td>

                <td sortable="'ent_type_name'" filter="{ent_type_name: 'text'}" data-title="'THEADER4' | translate" groupable="'ent_type_name'"> <!--Entity Type-->
                    [[entitytype.ent_type_name]]
                </td>

                <td sortable="'etn1_name'" filter="{etn1_name: 'text'}" data-title="'THEADER5' | translate" groupable="'etn1_name'"> <!--Transaction State-->
                    [[::entitytype.etn1_name]]
                </td>

                <td sortable="'p_a_v_name'" filter="{p_a_v_name: 'text'}" data-title="'Allowed Name'" groupable="'p_a_v_name'"> <!--Transaction State-->
                    [[::entitytype.p_a_v_name]]
                </td>

                <td sortable="'t_state_name'" data-title="'THEADER6' | translate" groupable="'t_state_name'"> <!--State-->
                    [[::entitytype.t_state_name]]
                </td>

                <td sortable="'state'" data-title="'THEADER7' | translate" groupable="'state'"> <!--State-->
                    [[::entitytype.state]]
                </td>

                <td sortable="'created_at'" data-title="'THEADER8' | translate"> <!--Created_at-->
                    [[ ::entitytype.created_at ]]
                </td>

                <td sortable="'updated_at'" data-title="'THEADER9' | translate"> <!--Updated_at-->
                    [[ ::entitytype.updated_at ]]
                </td>

                <td>
                    <button class="btn btn-default btn-xs btn-detail" ng-click="openModalForm('md', entitytype.id, 'edit')">[[ "BTNTABLE1" | translate]]</button>
                    {{--<button class="btn btn-info btn-xs btn-delete">[[ "BTNTABLE2" | translate]]</button>--}}
                    <button class="btn btn-danger btn-xs btn-delete" ng-click="delete(entitytype.id)">[[ "BTNTABLE3" | translate]]</button>
                </td>
            </tr>
        </table>
    </div>
@stop
@section('footerContent')
    <script src="<?= asset('app/controllers/entTypes.js') ?>"></script>
@stop