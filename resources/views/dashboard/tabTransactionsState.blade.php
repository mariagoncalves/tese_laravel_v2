
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                        <tr>
                                            <th>Transaction ID</th>
                                            <th>Transaction Type</th>
                                            <th>Transaction State</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr ng-repeat="transactionstate in transactionstates">
                                            <td>[[ transactionstate.transaction_id ]]</td>
                                            <td>[[ transactionstate.transaction.transaction_type.language[0].pivot.t_name ]]</td>
                                            <td>[[ transactionstate.t_state.language[0].pivot.name ]]</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <button type="button" class="btn btn-default btn-blue" ng-click="changeTabBoot_(transactionstates[transactionstates.length-1].transaction_id, 'Task Form', 'tabFormTask', 1, transactionstates[transactionstates.length-1].transaction.transaction_type_id, transactionstates[transactionstates.length-1].t_state_id)">Next</button>