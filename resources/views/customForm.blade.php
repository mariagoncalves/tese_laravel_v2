@extends('layouts.default')
@section('content')
    <div ng-controller="customformController">
        <div growl></div>
        <h2>{{trans("customForms/messages.Page_Name")}}</h2>

        {{--<button class="btn btn-default btn-xs btn-detail" ng-click="dotranslate()">TRANSLATE</button>--}}

        <br>
        <br>
        <button id="btn-add" class="btn btn-primary btn-xs" ng-click="openModalForm_CostumForm('md', 0, 'add')">{{trans("customForms/messages.THEADER7")}}</button>
        <br>
        <br>

        <div class="alert alert-danger" ng-show="tableParams.data.length == 0" ng-cloak>
            {{trans("customForms/messages.EMPTY_TABLE")}}
        </div>

        <table ng-table="tableParams" class="table table-condensed table-bordered table-hover" ng-show="tableParams.data.length != 0" ng-cloak>
            <tr class="ng-table-group" ng-repeat-start="group in $groups">
                <td colspan="6">
                    <a href="" ng-click="group.$hideRows = !group.$hideRows">
                        <span class="glyphicon" ng-class="{ 'glyphicon-chevron-right': group.$hideRows, 'glyphicon-chevron-down': !group.$hideRows }"></span>
                        <strong>[[ group.value ]]</strong>
                    </a>
                </td>
            </tr>
            <tr ng-hide="group.$hideRows" ng-repeat="customForm in group.data" ng-repeat-end>

                <td sortable="'custom_form_name'" filter="{custom_form_name : 'text'}" data-title="'{{trans("customForms/messages.THEADER1")}}'" groupable="'custom_form_name'"> <!--ID-->
                    [[::customForm.custom_form_name]]
                </td>

                {{--Arranjar os rowspan da transaction--}}
                {{--Preencher só uma vez os botões: drag/drop, addTrans e viewTran--}}
                <td ng-if="group.data[$index - 1].custom_form_id != group.data[$index].custom_form_id"> <!--ID-->
                    <button class="btn btn-primary btn-xs" ng-click="showDragDropWindowEnt(customForm.custom_form_id)" ng-if="customForm.transaction_type_name != null">{{trans("customForms/messages.BTNTABLE3")}}</button>
                    <button id="btn-add" class="btn btn-success btn-xs" ng-click="openModalForm_AddTransactionTypes('md', customForm.custom_form_id, 'add_ent_types')">{{trans("customForms/messages.BTNTABLE4")}}</button>
                    <button id="btn-add" class="btn btn-success btn-xs" ng-click="openModalForm_ViewTransactionTypes('md', customForm.custom_form_id)">{{trans("customForms/messages.BTNVIEW_TRAN_TYPES")}}</button>
                </td>

                <td ng-if="group.data[$index - 1].custom_form_id == group.data[$index].custom_form_id"> <!--ID-->
                </td>
                {{--Fim--}}

                {{--Arranjar os rowspan da transaction--}}
                {{--Preencher só uma vez o T_state_name--}}
                <td sortable="'t_state_name'" filter="{t_state_name : 'text'}" data-title="'{{trans("customForms/messages.THEADER8")}}'" ng-if="group.data[$index - 1].custom_form_id != group.data[$index].custom_form_id"> <!--ID-->
                    [[::customForm.t_state_name]]
                </td>

                <td sortable="'t_state_name'" filter="{t_state_name : 'text'}" data-title="'{{trans("customForms/messages.THEADER8")}}'" ng-if="group.data[$index - 1].custom_form_id == group.data[$index].custom_form_id"> <!--ID-->
                </td>
                {{--Fim--}}


                <td sortable="'transaction_type_id'" filter="{transaction_type_id : 'number'}" data-title="'{{trans("customForms/messages.THEADER2")}}'" ng-if="customForm.transaction_type_name == null"> <!--Name-->
                    {{trans("customForms/messages.NO_TRAN_TYPES")}}
                </td>

                <td sortable="'transaction_type_id'" filter="{transaction_type_id : 'number'}" data-title="'{{trans("customForms/messages.THEADER2")}}'" ng-if="customForm.transaction_type_name != null"> <!--Name-->
                    [[::customForm.transaction_type_id]]
                </td>

                <td sortable="'transaction_type_name'" filter="{transaction_type_name : 'text'}" data-title="'{{trans("customForms/messages.THEADER3")}}'" > <!--State-->
                    [[::customForm.transaction_type_name]]
                </td>

                <td sortable="'mandatory'"  data-title="'{{trans("customForms/messages.THEADER4")}}'" ng-if="customForm.transaction_type_name != null"> <!--Created_at-->
                    <button class="[[  customForm.mandatory ? 'btn btn-success btn-xs' : 'btn btn-danger btn-xs btn-delete']]" ng-click="updateMandatory(customForm.custom_form_id,customForm.transaction_type_id)"> [[ ::customForm.mandatory ? 'Yes' : 'No' ]]</button>
                </td>

                <td sortable="'mandatory'"  data-title="'{{trans("customForms/messages.THEADER4")}}'" ng-if="customForm.transaction_type_name == null"> <!--Created_at-->

                </td>

                <td sortable="'ent_state'" data-title="'{{trans("customForms/messages.THEADER5")}}'"> <!--Updated_at-->
                    [[::customForm.transaction_type_state]]
                </td>

                <td sortable="'updated_at'" data-title="'{{trans("customForms/messages.THEADER6")}}'"> <!--Updated_at-->
                    [[::customForm.transaction_type_updated_at]]
                </td>


                {{--Arranjar os rowspan da transaction--}}
                {{--Preencher só uma vez os botões: edit e history--}}
                <td ng-if="group.data[$index - 1].custom_form_id != group.data[$index].custom_form_id"> <!--ID-->
                    <button class="btn btn-default btn-xs btn-detail" ng-click="openModalForm_CostumForm('md', customForm.custom_form_id, 'edit')">{{trans("customForms/messages.BTNTABLE1")}}</button>
                    {{--<button class="btn btn-danger btn-xs btn-delete">[[ "BTNTABLE2" | translate]]</button>--}}
                    <button class="btn btn-danger btn-xs btn-delete" ng-click="remove(customForm.custom_form_id)">{{trans("customForms/messages.BTNREMOVE_TRAN_TYPES")}}</button>
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
