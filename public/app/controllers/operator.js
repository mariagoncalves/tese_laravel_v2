app.controller('operatorControllerJs', function($scope, $http, growl, API_URL, $translatePartialLoader, $translate, NgTableParams, MyService, $uibModal, $timeout) {

	$scope.getOperatorTable = function() {
        var initialParams = {
            sorting: { created_at: "desc" }, // Ordenação por defeito da tabela
            count: 5, // Número de dados por página na tabela
        };

        var initialSettings = {
            counts: [5, 10, 15], // Número possiveis de apresentação dos dados da tabela
            getData: function (params) {
                var filterObj = params.filter(),
                    sortObj   = params.sorting();

                return $scope.getOperatorTypes(params, filterObj, sortObj);
            }
        };

        $scope.tableParams = new NgTableParams(initialParams, initialSettings);
    };

    $scope.getOperatorTypes = function(params, filter, sort) {
        var url = '/operator/get_operator_types?page=' + params.page();

        url += '&count=' + params.count();

        if (filter.operatorFilter != undefined && filter.operatorFilter != '') {
            url += '&operator=' + filter.operatorFilter;
        }

        var colSorting  = Object.keys(sort)[0],
            typeSorting = sort[colSorting];
        // Parametro para ordenar os dados
        url += '&colSorting=' + colSorting + "&typeSorting=" + typeSorting;

        return $http.get(url).then(function (response) {
                params.total(response.data.total);
                return response.data.data;
            });
    };

    $scope.openModalOperator = function (size, modalstate, id, parentSelector) {

    	var modalInstance = $uibModal.open({
            animation: true,
            ariaLabelledBy: 'modal-title',
            ariaDescribedBy: 'modal-body',
            templateUrl: 'modalOperator',
            controller: 'ModalInstanceCtrl1',
            scope: $scope,
            size: size,
            resolve: {}
        }).rendered.then(function() {
            $scope.operator   = null;
            $scope.modalstate = modalstate;

            switch (modalstate) {
                case 'add':
                    $scope.id = id;
                    $scope.form_title = "ADD_FORM_NAME";
                    break;
                /*case 'edit':
                    $scope.form_title = "EDIT_FORM_NAME";
                    $scope.id = id;

                    $http.get(API_URL + '/getRelationsTypes/' + id)
                        .then(function(response) {
                            $scope.relation = response.data;
                            //$("[name=relation_name]").prop('disabled', 'disabled');
                        });
                    break;*/
                default:
                    break;
            }
        });
    };


    $scope.ModalInstanceCtrl1 = function ($scope, $uibModalInstance) {

        $scope.save = function(modalstate, id) {
            var url      = API_URL + "Operator";

            //var formData = JSON.parse(JSON.stringify(jQuery('#formOperator').serializeArray()));
            var formData = $("#operator").val();
            console.log("Dados do form: " + formData);

            if (modalstate === 'edit') {
                url += "/" + id ;
            }

            $http({
                method: 'POST',
                url: url,
                data: $.param(formData),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).then(function(response) {
                $scope.errors = [];
                // Actualizar os dados da tabela
                $scope.getOperatorTable();
                // Fechar o popup
                $scope.cancel();

                if (modalstate == "add") {
                    growl.success('SAVE_SUCCESS_MESSAGE', {title: 'SUCCESS'});
                } else {
                    growl.success('EDIT_SUCCESS_MESSAGE', {title: 'SUCCESS'});
                }
            }, function(response) {
                //Second function handles error
                if (response.status == 400) {
                    $scope.errors = response.data.error;
                } else if (response.status == 500) {
                    $scope.cancel();
                    growl.error(response.data.error, {title: 'error!'});
                }
            });
        };

        $scope.cancel = function () {
            $uibModalInstance.dismiss();
        };
    };



});