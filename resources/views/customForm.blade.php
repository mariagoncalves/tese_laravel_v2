@extends('layouts.default')
@section('content')
    <div ng-controller="customformController">
        <div growl></div>
        <h2>[["Page_Name" | translate]]</h2>

        <button class="btn btn-default btn-xs btn-detail" ng-click="dotranslate()">TRANSLATE</button>

        <br>
        <br>
        <button id="btn-add" class="btn btn-primary btn-xs" ng-click="openModalForm_CostumForm('md', 0, 'add')">[[ "THEADER7" | translate]]</button>

        <!-- Table-to-load-the-data Part -->
        {{--<table class="table table-striped" ng-init="getCustomForms()" st-safe-src="entities">
            <thead>
            <tr>
                <th> [[ "THEADER1" | translate]] </th>
                <th> [[ "THEADER2" | translate]] </th>
                <th> [[ "THEADER3" | translate]] </th>
                <th> [[ "THEADER4" | translate]] </th>
                <th> [[ "THEADER5" | translate]] </th>
                <th> [[ "THEADER6" | translate]] </th>
                <th> <button id="btn-add" class="btn btn-primary btn-xs" ng-click="openModalForm_PropAllowedValue('md', 0, 'add')">[[ "THEADER7" | translate]]</button></th>
            </tr>
            </thead>
            <tbody>
                <tr ng-repeat-start="customForm in customForms" ng-if="false" ng-init="innerIndex = $index"></tr>

                <td rowspan="[[ customForm.ent_types.length + 1 ]] " ng-if="customForm.ent_types[$index - 1].rel_type_id != customForm.id">
                    [[ customForm.language[0].pivot.name ]]

                    <div ng-if="customForm.ent_types.length > 1">
                        <button class="btn btn-primary btn-xs" ng-click="showDragDropWindowEnt(customForm.id)">[[ "BTNTABLE3" | translate]]</button>
                        <button id="btn-add" class="btn btn-success btn-xs" ng-click="openModalForm_AddEntTypes('md', customForm.id, 'add_ent_types')">[["BTNTABLE4" | translate]]</button>
                        <button id="btn-add" class="btn btn-success btn-xs" ng-click="openModalForm_ViewEntTypes('md', customForm.id)">[["BTNVIEW_ENT_TYPES" | translate]]</button>
                    </div>

                    <div ng-if="customForm.ent_types.length <= 1">
                        <button id="btn-add" class="btn btn-success btn-xs" ng-click="openModalForm_AddEntTypes('md', customForm.id, 'add_ent_types')">[["BTNTABLE4" | translate]]</button>
                        <button id="btn-add" class="btn btn-success btn-xs" ng-click="openModalForm_ViewEntTypes('md', customForm.id)">[["BTNVIEW_ENT_TYPES" | translate]]</button>
                    </div>


                </td>

                <td ng-if="customForm.ent_types.length == 0" colspan="5">[[ "NO_ENT_TYPES" | translate]]</td>
                <td ng-if="customForm.ent_types.length == 0" colspan="1">
                    <button class="btn btn-default btn-xs btn-detail" ng-click="openModalForm_PropAllowedValue('md', customForm.id, 'edit')">[[ "BTNTABLE1" | translate]]</button>
                    <button class="btn btn-danger btn-xs btn-delete">[[ "BTNTABLE2" | translate]]</button>
                </td>

                <tr ng-repeat="ent_type in customForm.ent_types">
                    <td>[[ ent_type.id ]]</td>
                    <td>[[ ent_type.language[0].pivot.name ]]</td>
                    <td>[[ (ent_type.mandatory == 1) ? 'Yes' : 'No' ]]</td>
                    <td>[[ ent_type.state ]]</td>
                    <td>[[ ent_type.updated_at ]]</td>
                    <td ng-if="$index == 0" rowspan="customForm.ent_types.length">
                        <button class="btn btn-default btn-xs btn-detail" ng-click="openModalForm_PropAllowedValue('md', customForm.id, 'edit')">[[ "BTNTABLE1" | translate]]</button>
                        <button class="btn btn-danger btn-xs btn-delete">[[ "BTNTABLE2" | translate]]</button>
                    </td>
                <tr ng-repeat-end ng-if="false"></tr>
                </tr>

            </tbody>
        </table>--}}

        <table ng-table="tableParams" class="table table-condensed table-bordered table-hover" ng-show="tableParams!=null" ng-cloak>
            <tr class="ng-table-group" ng-repeat-start="group in $groups">
                <td colspan="6">
                    <a href="" ng-click="group.$hideRows = !group.$hideRows">
                        <span class="glyphicon" ng-class="{ 'glyphicon-chevron-right': group.$hideRows, 'glyphicon-chevron-down': !group.$hideRows }"></span>
                        <strong>[[ group.value ]]</strong>
                    </a>
                </td>
            </tr>
            <tr ng-hide="group.$hideRows" ng-repeat="customForm in group.data" ng-repeat-end>

                <td sortable="'custom_form_name'" filter="{custom_form_name : 'text'}" data-title="'THEADER1' | translate" groupable="'custom_form_name'"> <!--ID-->
                    [[::customForm.custom_form_name]]
                </td>

                {{--Arranjar os rowspan da transaction--}}
                {{--Preencher só uma vez os botões: drag/drop, addTrans e viewTran--}}
                <td ng-if="group.data[$index - 1].custom_form_id != group.data[$index].custom_form_id"> <!--ID-->
                    <button class="btn btn-primary btn-xs" ng-click="showDragDropWindowEnt(customForm.custom_form_id)" ng-if="customForm.transaction_type_name != null">[[ "BTNTABLE3" | translate]]</button>
                    <button id="btn-add" class="btn btn-success btn-xs" ng-click="openModalForm_AddTransactionTypes('md', customForm.custom_form_id, 'add_ent_types')">[["BTNTABLE4" | translate]]</button>
                    <button id="btn-add" class="btn btn-success btn-xs" ng-click="openModalForm_ViewTransactionTypes('md', customForm.custom_form_id)">[["BTNVIEW_ENT_TYPES" | translate]]</button>
                </td>

                <td ng-if="group.data[$index - 1].custom_form_id == group.data[$index].custom_form_id"> <!--ID-->
                </td>
                {{--Fim--}}

                {{--Arranjar os rowspan da transaction--}}
                {{--Preencher só uma vez o T_state_name--}}
                <td sortable="'t_state_name'" filter="{t_state_name : 'text'}" data-title="'THEADER8' | translate" ng-if="group.data[$index - 1].custom_form_id != group.data[$index].custom_form_id"> <!--ID-->
                    [[::customForm.t_state_name]]
                </td>

                <td sortable="'t_state_name'" filter="{t_state_name : 'text'}" data-title="'THEADER8' | translate" ng-if="group.data[$index - 1].custom_form_id == group.data[$index].custom_form_id"> <!--ID-->
                </td>
                {{--Fim--}}


                <td sortable="'transaction_type_id'" filter="{transaction_type_id : 'number'}" data-title="'THEADER2' | translate" ng-if="customForm.transaction_type_name == null"> <!--Name-->
                    [[ "NO_ENT_TYPES" | translate]]
                </td>

                <td sortable="'transaction_type_id'" filter="{transaction_type_id : 'number'}" data-title="'THEADER2' | translate" ng-if="customForm.transaction_type_name != null"> <!--Name-->
                    [[::customForm.transaction_type_id]]
                </td>

                <td sortable="'transaction_type_name'" filter="{transaction_type_name : 'text'}" data-title="'THEADER3' | translate" > <!--State-->
                    [[::customForm.transaction_type_name]]
                </td>

                <td sortable="'mandatory'"  data-title="'THEADER4' | translate" ng-if="customForm.transaction_type_name != null"> <!--Created_at-->
                    <button class="[[  customForm.mandatory ? 'btn btn-success btn-xs' : 'btn btn-danger btn-xs btn-delete']]" ng-click="updateMandatory(customForm.custom_form_id,customForm.transaction_type_id)"> [[ ::customForm.mandatory ? 'Yes' : 'No' ]]</button>
                </td>

                <td sortable="'mandatory'"  data-title="'THEADER4' | translate" ng-if="customForm.transaction_type_name == null"> <!--Created_at-->

                </td>

                <td sortable="'ent_state'" data-title="'THEADER5' | translate"> <!--Updated_at-->
                    [[::customForm.transaction_type_state]]
                </td>

                <td sortable="'updated_at'" data-title="'THEADER6' | translate"> <!--Updated_at-->
                    [[::customForm.transaction_type_updated_at]]
                </td>


                {{--Arranjar os rowspan da transaction--}}
                {{--Preencher só uma vez os botões: edit e history--}}
                <td ng-if="group.data[$index - 1].custom_form_id != group.data[$index].custom_form_id"> <!--ID-->
                    <button class="btn btn-default btn-xs btn-detail" ng-click="openModalForm_CostumForm('md', customForm.custom_form_id, 'edit')">[[ "BTNTABLE1" | translate]]</button>
                    <button class="btn btn-danger btn-xs btn-delete">[[ "BTNTABLE2" | translate]]</button>
                </td>

                <td ng-if="group.data[$index - 1].custom_form_id == group.data[$index].custom_form_id"> <!--ID-->
                </td>
                {{--Fim--}}

            </tr>
        </table>
        <div>
            <posts-pagination></posts-pagination>
        </div>
    </div>
@stop
@section('footerContent')
    <script src="<?= asset('app/controllers/customform.js') ?>"></script>
@stop
