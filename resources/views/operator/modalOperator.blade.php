<div class="modal-content" id = "myModal">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" ng-click="cancel()" aria-label="Close"><span aria-hidden="true">×</span></button>
        <h4 class="modal-title" id="myModalLabel">Adicionar operadores</h4>
    </div>


    <div class="modal-body">
        <form id="formOperator" name="formOperator" class="form-horizontal" novalidate="">

            <div class="form-group">
                <label class="col-sm-3 control-label">Tipo de operador:</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="operator" name="operator">
                    <ul ng-repeat="error in errors.operator" style="padding-left: 15px;">
                        <li>[[ error ]]</li>
                    </ul>
                </div>
            </div>

        </form>
    </div>





    
    <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="btn-save" ng-click="save(modalstate, id)" >{{trans('relationTypes/messages.BTN1FORM')}}</button>
    </div>
</div> 
