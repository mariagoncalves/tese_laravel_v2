/**
 * Created by ASUS on 26/05/2017.
 */
app.controller('dashboardController', function($scope, $q, $http, growl, API_URL, $translatePartialLoader, $translate, NgTableParams, MyService, $uibModal, $timeout) {
    $translatePartialLoader.addPart('transactionTypes');

    setTimeout(function() { $translate.refresh(); }, 0);

    $scope.dotranslate = function() {
        var currentLang = $translate.proposedLanguage() || $translate.use();
        if (currentLang == "en")
            $translate.use('pt');
        else
            $translate.use('en');
    };

    $scope.type_class = "fa fa-fw fa-sort";
    $scope.type = 'asc';
    $scope.input = null;
    $scope.num = null;
    var fil_sort = false;
    $scope.sort = function(input,num) {
        $scope.input = input;
        $scope.num = num;
        if ($scope.type == 'asc' || $scope.type == 'desc')
            fil_sort = true;

        if ($scope.type == 'asc')
        {
            $scope.type_class = 'fa fa-fw fa-sort-asc';
            $scope.type = 'desc';
        }
        else
        {
            $scope.type_class = 'fa fa-fw fa-sort-desc';
            $scope.type = 'asc';
        }

        $scope.getTransacsTypes(input);
    };


    $scope.modal = [];
    $scope.modal_formTab = [];
    //https://stackoverflow.com/questions/36844064/dismiss-uibmodal-from-within
    $scope.openModalTask = function (size, parentSelector) {
        /*var parentElem = parentSelector ?
            angular.element($document[0].querySelector('.modal-demo ' + parentSelector)) : undefined;*/
        var modalInstance = $uibModal.open({
            animation: true,
            ariaLabelledBy: 'modal-title',
            ariaDescribedBy: 'modal-body',
            templateUrl: 'modalTask',
            controller: 'ModalInstanceCtrl',
            scope: $scope,
            size: size,
            //appendTo: parentElem,
            resolve: {
            }
        }).closed.then(function() {
            //handle ur close event here
            $scope.modal = [];
            $scope.modal_formTab = [];
            $scope.modal_processTab = [];
            //alert("modal closed");
        });

        /*modalInstance.result.then(function () {
            alert('Modal success at:' + new Date());
        }, function () {
            //alert('Modal dismissed at: ' + new Date());
            //$scope.modal = null;
        });*/
    };

    $scope.modal_processTab = [];
    $scope.modal_formTab.relTypeExist = false;

    $scope.ModalInstanceCtrl = function ($scope, $uibModalInstance, $timeout) {
        $scope.processtypes = function() {
            $http.get(API_URL + "/proc_types/get_procs_types")
                .then(function (response) {
                    $scope.processtypes = response.data;
                });
        };
        $scope.processtypes();

        /*$scope.loadEntities1 = function($id) {
            $http.get(API_URL + "/dashboard/get_entities1_for_relType/" + $id)
                .then(function (response) {
                    $scope.entities1 = response.data;
                });
        };

        $scope.loadEntities2 = function($id) {
            $http.get(API_URL + "/dashboard/get_entities2_for_relType/" + $id)
                .then(function (response) {
                    $scope.entities2 = response.data;
                });
        };*/

        $scope.loadProcs = function($id) {
            $scope.modal_processTab.process = null;
            $http.get(API_URL + "/dashboard/get_procs_user_selected/" + $id)
                .then(function (response) {
                    $scope.processes = response.data;
                });
        };




        /*$scope.propsForm = function($id,$type) {
            $scope.modal_formTab.loading = true;
            $http.get(API_URL + "/dashboard/get_props_form/" + $id + "/" + $type)
                .then(function (response) {
                    if (response.data.emptyRelType === false)
                    {
                        $scope.modal_formTab.relTypeExist = true;
                        //carregar as duas selectboxes
                        var id = response.data.rel_type_id;
                        $scope.loadEntities1(id);
                        $scope.loadEntities2(id);
                        console.log($scope.entities1);
                    }
                    else
                    {
                        $scope.modal_formTab.relTypeExist = false;
                    }

                    $scope.modal_formTab.propsform = response.data.data;
                }, function errorCalback(response) {
                        if (response.status == 400)
                        {
                            alert("Não existem propriedades");
                        }
                    }
                ).finally(function() {
                // called no matter success or failure
                $scope.modal_formTab.loading = false;
            });
        };*/

        $scope.verParEntType = function ($id) {
            $scope.formChild($id);
        };
        $scope.formChild = function($id) {
            $http.get(API_URL + "/dashboard/get_props_form_child/" + $id)
                .then(function (response) {
                    $scope.modal_formTab.propsformChild = response.data;
                }).finally(function() {
                // called no matter success or failure
            });
        };

        $scope.tabs = [{
            title: 'Process',
            templateUrl: 'tabProcess'
        }];

        /*$scope.tabs = [{
            title: 'Task',
            templateUrl: 'tabTask'
        }];*/

        $scope.isUserInicExecOfTrans = function ($trans_id) {
            var deferred = $q.defer();
            $http.get(API_URL + "/dashboard/is_User_InicAndExec_trans/" + $trans_id)
                .then(function (response) {
                    deferred.resolve(response);
                }, function errorCalback(response)
                {
                    deferred.reject(response);
                }).finally(function() {
                // called no matter success or failure
            });

            return deferred.promise;
        };

        var repet = false;
        $scope.modal.tabnumber = 3;
        $scope.modal.transaction_type_id = null;
        var type = 1;

        Array.prototype.remove = function(from, to) {
            var rest = this.slice((to || from) + 1 || this.length);
            this.length = from < 0 ? this.length + from : from;
            return this.push.apply(this, rest);
        };

        $scope.changeTabBoot = function ($id, $title, $templateurl, $tabnumber) {
            /*angular.forEach($scope.tabs, function(value, key) {

                if (value["title"] == 'Task')
                    $scope.tabs.splice(key, 1);
            });*/
            if (type > 5) {
                type = 1;
                //$scope.modal.tabnumber = 3;
                return;
            }

            alert("id: " + $id + ", tabnumber" + $tabnumber);
            //$scope.tabs.splice(($scope.activeTabIndex + 1), ($scope.tabs.length - 1));
            if ($tabnumber == 3) {
                $scope.tabs.splice($scope.activeTabIndex);
            }
            else
            {
                $scope.tabs.splice($scope.activeTabIndex + 1);
            }

            if ($id != undefined) {
                //$scope.addTab($title,$templateurl);
                switch ($tabnumber) {
                    case 1:
                        alert("Selected Case Number is 1");
                        $scope.addTab($title,$templateurl);
                        $scope.transacsTypesUserCanInit($id);
                        break;
                    default:
                    case 2:
                        alert("Selected Case Number is 2");
                        $scope.isUserInicExecOfTrans($id).then(function(data) {
                                if (data.data == true) {
                                    //$scope.modal.tabnumber++;
                                    $scope.modal.transaction_type_id = $id;
                                }
                            }
                        ).catch(function(response){
                            if (response.status == 400)
                            {

                            }
                        });

                        if ($tabnumber == 2)
                        {
                            type=1;
                        }
                        else
                        {
                            type++;
                        }
                        //$scope.modal_formTab = [];
                        $scope.propsForm($id,type).then(function(data) {
                                    $scope.addTab($title,$templateurl);
                            }
                        ).catch(function(response){
                            if (response == 400)
                            {
                                $scope.changeTabBoot($id, $title, $templateurl, ++$tabnumber); //nao pode ser $tabnumber++

                                /*$scope.taberror = [];
                                $scope.taberror.message = "Não existe formulário associado a este tipo de transacção";
                                $scope.addTab("Error","tabError");*/
                            }
                        });
                        break;

                }
            }
        };

        $scope.addTab = function($title, $templateurl) {
            $scope.tabs.push({
                title: $title,
                templateUrl: $templateurl
            });

            $timeout(function(){
                $scope.activeTabIndex = ($scope.tabs.length - 1);
            });
        };

        $scope.cancel = function () {
            $uibModalInstance.dismiss('cancel');
        };
    };

    $scope.propsForm = function($id, $type)
    {
        var deferred = $q.defer();
        $scope.modal_formTab = [];
        //$scope.modal_formTab.loading = true;
        $http.get(API_URL + "/dashboard/get_props_form/" + $id + "/" + $type)
            .then(function (response) {
                    if (response.data.emptyRelType === false)
                    {
                        $scope.modal_formTab.relTypeExist = true;
                        //carregar as duas selectboxes
                        var id = response.data.rel_type_id;
                        $scope.loadEntities1(id);
                        $scope.loadEntities2(id);
                    }
                    else
                    {
                        $scope.modal_formTab.relTypeExist = false;
                    }

                    $scope.modal_formTab.propsform = response.data.data;

                    deferred.resolve(response.status);
                }, function errorCalback(response)
                {
                    deferred.reject(response.status);
                }
            ).finally(function() {
            // called no matter success or failure
            //$scope.modal_formTab.loading = false;
        });

        return deferred.promise;
    };

    $scope.loadEntities1 = function($id) {
        $http.get(API_URL + "/dashboard/get_entities1_for_relType/" + $id)
            .then(function (response) {
                $scope.entities1 = response.data;
            });
    };

    $scope.loadEntities2 = function($id) {
        $http.get(API_URL + "/dashboard/get_entities2_for_relType/" + $id)
            .then(function (response) {
                $scope.entities2 = response.data;
            });
    };

    $scope.openModalProcess = function (size, parentSelector) {
        /*var parentElem = parentSelector ?
         angular.element($document[0].querySelector('.modal-demo ' + parentSelector)) : undefined;*/
        var modalInstance = $uibModal.open({
            animation: true,
            ariaLabelledBy: 'modal-title',
            ariaDescribedBy: 'modal-body',
            templateUrl: 'modalProcess',
            controller: 'ModalInstanceCtrl1',
            scope: $scope,
            size: size,
            //appendTo: parentElem,
            resolve: {
            }
        }).closed.then(function() {
            //handle ur close event here
            alert("modal closed");
        });

        /*modalInstance.result.then(function () {
            alert('Modal success at:' + new Date());
        }, function () {
            //alert('Modal dismissed at: ' + new Date());
            //$scope.modal = null;
        });*/
    };

    $scope.ModalInstanceCtrl1 = function ($scope, $uibModalInstance) {
        $scope.cancel = function () {
            $uibModalInstance.dismiss('cancel');
        };
    };





    $scope.procstypes = function() {
        $http.get(API_URL + "/proc_types/get_procs_types")
            .then(function (response) {
                $scope.processtypes = response.data;
            });
    };
    $scope.procstypes();

    $scope.langs = function() {
        $http.get(API_URL + "/proc_types/get_langs")
            .then(function (response) {
                $scope.langs = response.data;
            });
    };

    $scope.transacsTypesUserCanInit = function($id) {
        $http.get(API_URL + "/dashboard/get_transtypeusercaninit/" + $id)
            .then(function (response) {
                $scope.transactiontypes = response.data;
            });
    };

    $scope.executers = function() {
        $http.get(API_URL + "/exec/get_executers")
            .then(function (response) {
                $scope.executers = response.data;
            });
    };


    $scope.getInicTrans = function() {
        $http.get(API_URL + "/dashboard/get_all_inic_trans")
            .then(function (response) {
                $scope.transactionsInic = response.data;
            });
    };
    $scope.getInicTrans();

    $scope.getExecTrans = function() {
        $http.get(API_URL + "/dashboard/get_all_exec_trans")
            .then(function (response) {
                $scope.transactionsExec = response.data;
            });
    };
    $scope.getExecTrans();





    $scope.openModalTransactionState = function (size, id, actorCan) {
        //parentSelector,
        /*var parentElem = parentSelector ?
         angular.element($document[0].querySelector('.modal-demo ' + parentSelector)) : undefined;*/
        var modalInstance = $uibModal.open({
            animation: true,
            ariaLabelledBy: 'modal-title',
            ariaDescribedBy: 'modal-body',
            templateUrl: 'modalTransactionState',
            controller: 'ModalInstanceCtrl_trans_state',
            scope: $scope,
            size: size,
            //appendTo: parentElem,
            resolve: {
                trans_id: function() {
                    return id
                },
                actor_Can: function() {
                    return actorCan
                }
            }
        }).closed.then(function() {
            //handle ur close event here
            //alert("modal closed");
        });

        /*modalInstance.result.then(function () {
         alert('Modal success at:' + new Date());
         }, function () {
         //alert('Modal dismissed at: ' + new Date());
         //$scope.modal = null;
         });*/
    };

    $scope.ModalInstanceCtrl_trans_state = function ($scope, $uibModalInstance, trans_id, actor_Can) {
        $scope.tabs = [{
            title: 'Transaction State',
            templateUrl: 'tabTransactionState'
        }];

        $scope.actorCan = actor_Can;

        $scope.changeTabBoot_ = function ($id, $title, $templateurl, $tabnumber, $trans_type_id) {
            $scope.tabs.splice(($scope.activeTabIndex + 1), ($scope.tabs.length - 1));

            if ($id != undefined) {
                //$scope.addTab($title,$templateurl);
                switch ($tabnumber) {
                    case 1:
                        alert("Selected Case Number is 1");
                        $scope.verifyIfCanDoNextTransactionState($id,$scope.t_state_id,$scope.actorCan, $title, $templateurl, $trans_type_id);
                        break;
                    case 2:
                        alert("Selected Case Number is 2");

                        break;
                    default:

                }
            }
        };

        $scope.addTab = function($title, $templateurl) {
            $scope.tabs.push({
                title: $title,
                templateUrl: $templateurl
            });

            $timeout(function(){
                $scope.activeTabIndex = ($scope.tabs.length - 1);
            });
        };

        $scope.verifyIfCanDoNextTransactionState = function($id,$t_state_id,$actorCan, $title, $templateurl, $trans_type_id) {
            MyService.verifyCanDoNextTransState($id,$t_state_id,$actorCan, $title, $templateurl, $trans_type_id).then(function (data) {
                if (data.canAdvance === true) {
                    //$scope.modal_formTab = [];
                    var type = data.nextState;

                    //a guarda da recursividade
                    if (type > 5)
                    {
                        return;
                    }

                    alert("The next transaction state is: " + type);
                    $scope.propsForm($id,type).then(function(data) {
                            $scope.addTab($title,$templateurl);
                        }
                    ).catch(function(response){
                        if (response == 400)
                        {
                            //recursividade
                            $scope.verifyIfCanDoNextTransactionState($id,$t_state_id+1,$actorCan, $title, $templateurl, $trans_type_id);
                        }
                        else
                        {
                            $scope.taberror = [];
                            $scope.taberror.message = "Não existe formulário associado a este tipo de transacção";
                            $scope.addTab("Error","tabError");
                        }
                    });
                }
                else
                {
                    alert("Não pode seguir para o proximo passo");
                }
            }).catch(function (response) {
                    alert("erro");
                    console.log(response.status);
                });
        };

        /*$scope.verifyIfCanDoNextTransactionState = function($id,$t_state_id,$actorCan, $title, $templateurl, $trans_type_id) {
            $http({
                method: 'POST',
                url: API_URL + "/dashboard/verify_can_do_next_trans_state/" + $id,
                data: $.param({ 't_state_id' : $t_state_id,
                        'actorCan': $actorCan,
                        'transTypeId':$trans_type_id
                    }
                ),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                //headers: {'Content-Type': 'json'}
            }).then(function (response) {
                if (response.data == true) {
                    $scope.addTab($title,$templateurl);
                    $scope.modal_formTab = [];
                    var type = $t_state_id;
                    $scope.propsForm($id, type);
                }
                else
                {
                    alert("Não pode seguir para o proximo passo");
                }
            });
        };*/

        $scope.trans_states = function($id) {
            $http.get(API_URL + "/dashboard/get_states_from_transaction/" + $id)
                .then(function (response) {
                    $scope.transactionstates = response.data.data;
                    $scope.t_state_id = response.data.t_state_id;
                });
        };
        $scope.trans_states(trans_id);

        $scope.cancel = function () {
            $uibModalInstance.dismiss('cancel');
        };
    };





    $scope.openModalProcessTransactions = function (size, parentSelector) {
        /*var parentElem = parentSelector ?
         angular.element($document[0].querySelector('.modal-demo ' + parentSelector)) : undefined;*/
        var modalInstance = $uibModal.open({
            animation: true,
            ariaLabelledBy: 'modal-title',
            ariaDescribedBy: 'modal-body',
            templateUrl: 'modalProcessTransactions',
            controller: 'ModalInstanceCtrl_procs_trans_state',
            scope: $scope,
            size: size,
            //appendTo: parentElem,
            resolve: {
            }
        }).closed.then(function() {
            //handle ur close event here
            //alert("modal closed");
        });

        /*modalInstance.result.then(function () {
         alert('Modal success at:' + new Date());
         }, function () {
         //alert('Modal dismissed at: ' + new Date());
         //$scope.modal = null;
         });*/
    };

    $scope.ModalInstanceCtrl_procs_trans_state = function ($scope, $uibModalInstance) {
        $scope.tabs = [{
            title: 'Transactions',
            templateUrl: 'tabTransactions'
        }];

        $scope.cancel = function () {
            $uibModalInstance.dismiss('cancel');
        };
    };













    $scope.processtypes = [];
    $scope.totalPages = 0;
    $scope.currentPage = 1;
    $scope.range = [];

    var fil = false;
    $scope.filter = function()
    {
        var x = [ this.search_process_type, this.search_id, this.search_name, this.search_result_type, this.search_state, this.search_executer ];
        fil = MyService.filter(x);
        $scope.getTransacsTypes();
    };

    $scope.getTransacsTypes = function(pageNumber) {

        if (pageNumber === undefined) {
            pageNumber = '1';
        }

        var url='';
        if (fil === true)
        {
            if ($scope.search_process_type)
                url += '&s_process_type=' + $scope.search_process_type;

            if ($scope.search_id)
                url += '&s_id=' + $scope.search_id;

            if ($scope.search_name)
                url += '&s_name=' + $scope.search_name;

            if ($scope.search_result_type)
                url += '&s_result_type=' + $scope.search_result_type;

            if ($scope.search_state)
                url += '&s_state=' + $scope.search_state;

            if ($scope.search_executer)
                url += '&s_executer=' + $scope.search_executer;
        }

        if (fil_sort === true)
        {
            url += '&input_sort=' + $scope.input + '&type=' + $scope.type;
        }
        //Process_Type

        $http.get('/transacs_types/get_transacs_types?page='+pageNumber+url).then(function(response) {
            $scope.transactiontypes = response.data.data; //quando é procurado do processtypes para a linguagem

            $scope.totalPages = response.data.last_page;
            $scope.currentPage = response.data.current_page;

            // Pagination Range
            var pages = [];

            for (var i = 1; i <= response.data.last_page; i++) {
                pages.push(i);
            }

            $scope.range = pages;
        });
    };

    //show modal form
    $scope.togglemyModalNewProcess = function(modalstate, id) {
        switch (modalstate) {
            case 'add':
                /*$scope.id = id;
                 $scope.form_title = "ADD_FORM_NAME";*/
                break;
            case 'edit':
                /*$scope.form_title = "EDIT_FORM_NAME";
                 $scope.id = id;
                 $http.get(API_URL + 'transacs_types/get_transacs_types/' + id)
                 .then(function(response) {
                 $scope.transactiontype = response.data;
                 });*/
                break;
            default:
                break;
        }
        $('#myModalNewProcess').modal('show');
    };

    $scope.langs();
    $scope.executers();
    //show modal form
    $scope.toggle = function(modalstate, id) {
        $scope.modalstate = modalstate;

        switch (modalstate) {
            case 'add':
                $scope.id = id;
                $scope.form_title = "ADD_FORM_NAME";
                break;
            case 'edit':
                $scope.form_title = "EDIT_FORM_NAME";
                $scope.id = id;
                $http.get(API_URL + 'transacs_types/get_transacs_types/' + id)
                    .then(function(response) {
                        $scope.transactiontype = response.data;
                    });
                break;
            default:
                break;
        }
        console.log(id);
        $('#myModal').modal('show');
        $scope.errors = null;
        $scope.process = null;
    };

    $scope.delete = function(id) {
        var url = API_URL + "Transaction_Type_del/" + id;

        $http({
            method: 'POST',
            url: url,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            //headers: {'Content-Type': 'json'}
        }).then(function (response) {
            growl.success('This is success message.',{title: 'Success!'});
            $('#myModal').modal('hide');
            $scope.getTransacsTypes();
        }, function errorCallback(response) {
            if (response.status == 400)
            {
                growl.error('This is error message.',{title: 'error!'});
            }
            else
            {
                $scope.errors = response.data;
            }
        });
    };

    //save new record / update existing record
    $scope.save = function(modalstate, id) {
        var url = API_URL + "Transaction_Type";

        //append employee id to the URL if the form is in edit mode
        if (modalstate === 'edit') {
            url += "/" + id;
        }

        $http({
            method: 'POST',
            url: url,
            data: $.param({ 'language_id' : $scope.transactiontype.language[0].id,
                't_name': $scope.transactiontype.language[0].pivot.t_name,
                'rt_name': $scope.transactiontype.language[0].pivot.rt_name,
                'process_type_id': $scope.transactiontype.process_type_id,
                'state': $scope.transactiontype.state,
                'executer' : $scope.transactiontype.executer_actor.language[0].pivot.actor_id
                }
                ),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            //headers: {'Content-Type': 'json'}
        }).then(function (response) {
            growl.success('This is success message.',{title: 'Success!'});
            $('#myModal').modal('hide');
            $scope.getTransacsTypes();
        }, function errorCallback(response) {
            if (response.status == 400)
            {
                growl.error('This is error message.',{title: 'error!'});
            }
            else
            {
                $scope.errors = response.data;
            }
            //console.log(response);
        });
    };
}).directive('postsPagination', function(){
    return{
        restrict: 'E',
        template: '<ul class="pagination">'+
        '<li ng-show="currentPage != 1"><a href="javascript:void(0)" ng-click="getTransacsTypes(1)">&laquo;</a></li>'+
        '<li ng-show="currentPage != 1"><a href="javascript:void(0)" ng-click="getTransacsTypes(currentPage-1)">&lsaquo; [["BTNPAGINATION2" | translate]]</a></li>'+
        '<li ng-repeat="i in range" ng-class="{active : currentPage == i}">'+
        '<a href="javascript:void(0)" ng-click="getTransacsTypes(i)">{{i}}</a>'+
        '</li>'+
        '<li ng-show="currentPage != totalPages"><a href="javascript:void(0)" ng-click="getTransacsTypes(currentPage+1)">[["BTNPAGINATION1" | translate]] &rsaquo;</a></li>'+
        '<li ng-show="currentPage != totalPages"><a href="javascript:void(0)" ng-click="getTransacsTypes(totalPages)">&raquo;</a></li>'+
        '</ul>'
    };
});