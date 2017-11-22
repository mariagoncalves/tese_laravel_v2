@extends('layouts.default')
@section('content')
    <div ng-controller="dashboardController">
        {{--<h2>[["Page_Name" | translate]]</h2>--}}
        <h2>{{trans("dashboard/messages.Page_Name")}}{{--<span class="label label-success">Approved</span>--}}</h2>

        <div growl reference="80" inline="false">
        </div>
        <div class="panel panel-green">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-clock-o fa-fw"></i>{{trans("dashboard/messages.TransactionsPanelName")}}</h3>
            </div>
            <div class="panel-body" ng-cloak>
                <div class="col-lg-2 col-md-6" ng-repeat="transactiontype in ::transactiontypes_">
                <div class="panel panel-green">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-lg-12 text-center">
                                <h4>[[transactiontype.language[0].pivot.t_name]]</h4>
                            </div>
                        </div>
                    </div>
                        <div class="panel-footer text-center">
                            <button type="button" class="btn btn-md btn-default" ng-click="openModalTask('xl',transactiontype.id, transactiontype.init_proc, transactiontype.process_type_id)">{{trans("dashboard/messages.BTNTransactionPanel")}} <span><i class="fa fa-arrow-circle-right"></i></span></button>
                            <div class="clearfix"></div>
                        </div>
                </div>
                </div>
            </div>
        </div>

        <div class="panel panel-yellow">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-clock-o fa-fw"></i>{{trans("dashboard/messages.CustomFormsPanelName")}}</h3>
            </div>
            <div class="panel-body" ng-cloak>
                <div class="col-lg-2 col-md-6" ng-repeat="customform in customforms_">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-lg-12 text-center">
                                    <h4>[[::customform.language[0].pivot.name]]</h4>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer text-center">
                            <button type="button" class="btn btn-md btn-default" ng-click="openModalCustomFormTask('xl',customform.id, customform.init_proc)">Start <span><i class="fa fa-arrow-circle-right"></i></span></button>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-clock-o fa-fw"></i> {{trans("dashboard/messages.ExistingInicTransactionsPanelName")}}</h3>
            </div>
            <div class="panel-body" ng-cloak>
                <div class="alert alert-danger" ng-show="tableParamsInicTrans==null">
                    [[ "EMPTY_TABLE" | translate ]] [[  "Page_Name" | translate ]]
                </div>
                <div class="table-responsive">
                    <table ng-table="tableParamsInicTrans" class="table table-condensed table-bordered table-hover" ng-show="tableParamsInicTrans!=null">
                        <tr class="ng-table-group" ng-repeat-start="group in $groups">
                            <td colspan="1">
                                <a href="" ng-click="group.$hideRows = !group.$hideRows">
                                    <span class="glyphicon" ng-class="{ 'glyphicon-chevron-right': group.$hideRows, 'glyphicon-chevron-down': !group.$hideRows }"></span>
                                    <strong>[[ ::group.value ]]</strong>
                                </a>
                            </td>
                        </tr>
                        <tr ng-hide="group.$hideRows" ng-repeat="transaction in group.data" ng-repeat-end>
                            <td sortable="'process_type_name'" filter="{process_type_name: 'text'}" data-title="'Process Type'" groupable="'process_type_name'"> <!--Process Type-->
                                [[::transaction.process_type_name]]
                            </td>

                            <td sortable="'process_name'" filter="{process_name: 'text'}" data-title="'Process'" groupable="'process_name'"> <!--Transaction Type-->
                                [[::transaction.process_name]]
                            </td>

                            <td sortable="'transaction_id'" filter="{transaction_id: 'number'}" data-title="'Transaction ID'" groupable="'transaction_id'"> <!--ID-->
                                [[::transaction.transaction_id]]
                            </td>

                            <td sortable="'t_name'" filter="{t_name: 'text'}" data-title="'Transaction Type'" groupable="'t_name'"> <!--Entity Type-->
                                [[::transaction.t_name]]
                            </td>

                            <td sortable="'t_state_name'" filter="{t_state_name: 'text'}" data-title="'Transaction State'" groupable="'t_state_name'"> <!--Transaction State-->
                                [[::transaction.t_state_name]]
                                {{--<div class="progress progress-sm active">
                                    <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="[[20*(transaction.t_state_name.split('->').length)]]" aria-valuemin="0" aria-valuemax="100" ng-style="{ 'width' : (20*(transaction.t_state_name.split('->').length))+'%'}">
                                        <span class="sr-only">20% Complete</span>
                                    </div>
                                </div>--}}
                            </td>

                            <td sortable="'created_at'" data-title="'Created_at' | translate">
                                [[::transaction.created_at ]]
                            </td>

                            {{--<td sortable="'updated_at'" data-title="'Updated_at' | translate">
                                [[::transaction.updated_at ]]
                            </td>--}}

                            <td data-title="'Actor CAN'"> <!--Transaction State-->
                                [[::transaction.Type]]
                            </td>

                            <td>
                                <button type="button" class="btn btn-sm btn-success" ng-click="openModalTransactionState('lg',transaction.transaction_id,transaction.Type, transaction.process_id, transaction.transaction_type_id)">See Process</button>
                            </td>
                        </tr>
                    </table>
                </div>
                <br>
                <div class="text-right">
                    <a href="#">View All Activity <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>

        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-clock-o fa-fw"></i>{{trans("dashboard/messages.ExistingExecTransactionsPanelName")}}</h3>
            </div>
            <div class="panel-body" ng-cloak>
                <div class="alert alert-danger" ng-show="tableParamsExecTrans==null">
                    [[ "EMPTY_TABLE" | translate ]] [[  "Page_Name" | translate ]]
                </div>
                <div class="table-responsive">
                    <table ng-table="tableParamsExecTrans" class="table table-condensed table-bordered table-hover" ng-show="tableParamsExecTrans!=null">
                        <tr class="ng-table-group" ng-repeat-start="group in $groups">
                            <td colspan="1">
                                <a href="" ng-click="group.$hideRows = !group.$hideRows">
                                    <span class="glyphicon" ng-class="{ 'glyphicon-chevron-right': group.$hideRows, 'glyphicon-chevron-down': !group.$hideRows }"></span>
                                    <strong>[[ ::group.value ]]</strong>
                                </a>
                            </td>
                        </tr>
                        <tr ng-hide="group.$hideRows" ng-repeat="transaction in group.data" ng-repeat-end>
                            <td sortable="'process_type_name'" filter="{process_type_name: 'text'}" data-title="'Process Type'" groupable="'process_type_name'"> <!--Process Type-->
                                [[::transaction.process_type_name]]
                            </td>

                            <td sortable="'process_name'" filter="{process_name: 'number'}" data-title="'Process'" groupable="'process_name'"> <!--Transaction Type-->
                                [[::transaction.process_name]]
                            </td>

                            <td sortable="'transaction_id'" filter="{transaction_id: 'number'}" data-title="'Transaction ID'" groupable="'transaction_id'"> <!--ID-->
                                [[::transaction.transaction_id]]
                            </td>

                            <td sortable="'t_name'" filter="{t_name: 'text'}" data-title="'Transaction Type'" groupable="'t_name'"> <!--Entity Type-->
                                [[::transaction.t_name]]
                            </td>

                            <td sortable="'t_state_name'" filter="{t_state_name: 'text'}" data-title="'Transaction State'" groupable="'t_state_name'"> <!--Transaction State-->
                                [[::transaction.t_state_name]]
                            </td>

                            <td sortable="'created_at'" data-title="'Created_at' | translate">
                                [[ ::transaction.created_at ]]
                            </td>

                            {{--<td sortable="'updated_at'" data-title="'Updated_at' | translate">
                                [[ ::transaction.updated_at ]]
                            </td>--}}

                            <td data-title="'Actor CAN'"> <!--Transaction State-->
                                [[::transaction.Type]]
                            </td>

                            <td>
                                <button type="button" class="btn btn-sm btn-success" ng-click="openModalTransactionState('lg',transaction.transaction_id,transaction.Type, transaction.process_id, transaction.transaction_type_id)">See Process</button>
                            </td>
                        </tr>
                    </table>
                </div>
                <br>
                <div class="text-right">
                    <a href="#">View All Activity <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
    </div>
@stop
@section('footerContent')
    <script src="<?= asset('app/controllers/dashboard.js') ?>"></script>
@stop