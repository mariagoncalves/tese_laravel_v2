
                                <div growl reference="[[index]]">
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                        <tr>
                                            <th>{{trans("dashboard/modalTransactionState.TRANS_ID")}}</th>
                                            <th>{{trans("dashboard/modalTransactionState.TRANS_TYPE")}}</th>
                                            <th>{{trans("dashboard/modalTransactionState.TRANS_STATE")}}</th>
                                            <th>{{trans("dashboard/modalTransactionState.TRANS_ACK")}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr ng-repeat="transactionstate in transactionstates">
                                            <td>[[ transactionstate.transaction_id ]]</td>
                                            <td>[[ transactionstate.transaction.transaction_type.language[0].pivot.t_name ]]</td>
                                            <td>[[ transactionstate.t_state.language[0].pivot.name ]]</td>
                                            <td>[[ transactionstate.transaction_ack[0].viewed_on ]] [[ transactionstate.transaction_ack[0].user.user_name ]]</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <button type="button" class="btn btn-default btn-blue" ng-click="changeTabBoot('Task Form', 'tabFormTask', -1, transactionstates[transactionstates.length-1].t_state_id)">{{trans("dashboard/modal.BTN_NEXT")}}</button>
                                <button type="button" class="btn btn-default btn-info"
                                        ng-if="((transactionstates[transactionstates.length-1].transaction_ack.length === 0 || transactionstates[transactionstates.length-1].transaction_ack[0] == null)
                                         && ((actorCan === 'Iniciator' && (transactionstates[transactionstates.length-1].t_state_id === 2 || transactionstates[transactionstates.length-1].t_state_id === 3 || transactionstates[transactionstates.length-1].t_state_id === 4))
                                        || ((actorCan === 'Executer') && (transactionstates[transactionstates.length-1].t_state_id === 1 || transactionstates[transactionstates.length-1].t_state_id === 5))))"
                                        ng-click="trans_ack(transactionstates[transactionstates.length-1])">{{trans("dashboard/modalTransactionState.BTN_ACK")}}</button>