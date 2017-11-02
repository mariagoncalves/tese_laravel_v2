@extends('layouts.default')
@section('content')
    <div ng-controller="propUnitTypeController">
        <h2>[["Page_Name" | translate]]</h2>
        <div growl></div>

        <button class="btn btn-default btn-xs btn-detail" ng-click="dotranslate()">TRANSLATE</button>

        <br><br>
        <button id="btn-add" class="btn btn-success btn-xs" ng-click="openModalForm('md', 0, 'add')">[["THEADER7" | translate]]</button>
        <br><br>

        <div class="alert alert-danger" ng-show="tableParams==null">
            [[ "EMPTY_TABLE" | translate ]] [[  "Page_Name" | translate ]]
        </div>

        <table ng-table="tableParams" class="table table-condensed table-bordered table-hover" ng-show="tableParams!=null">
            <tr ng-repeat="unittype in $data">
                <td sortable="'id'" filter="{id: 'number'}" data-title="'THEADER1' | translate"> <!--ID-->
                    [[::unittype.id]]
                </td>

                <td sortable="'name'" filter="{name: 'text'}" data-title="'THEADER2' | translate"> <!--Name-->
                    [[::unittype.name]]
                </td>

                <td sortable="'state'" data-title="'THEADER3' | translate"> <!--State-->
                    [[::unittype.state]]
                </td>

                <td sortable="'created_at'" data-title="'THEADER4' | translate"> <!--Created_at-->
                    [[ ::unittype.created_at ]]
                </td>

                <td sortable="'updated_at'" data-title="'THEADER5' | translate"> <!--Updated_at-->
                    [[ ::unittype.updated_at ]]
                </td>

                <td>
                    <button class="btn btn-warning btn-xs btn-detail" ng-click="openModalForm('md', unittype.id, 'edit')">[[ "BTNTABLE1" | translate]]</button>
                    <button class="btn btn-primary btn-xs btn-delete">[[ "BTNTABLE2" | translate]]</button>
                </td>
            </tr>
        </table>
    </div>
@stop
@section('footerContent')
    <script src="<?= asset('app/controllers/propunittype.js') ?>"></script>
@stop