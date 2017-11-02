/**
 * Created by ASUS on 26/05/2017.
 */
app.controller('dashboardController', function($scope, $q, $http, growl, API_URL, $translatePartialLoader, $translate, NgTableParams, MyService, $uibModal, $timeout, FileUploader) {
    $scope.oneAtATime = true;

    $scope.groups = [
        {
            title: 'Dynamic Group Header - 1',
            content: 'Dynamic Group Body - 1'
        },
        {
            title: 'Dynamic Group Header - 2',
            content: 'Dynamic Group Body - 2'
        }
    ];

    $scope.items = ['Item 1', 'Item 2', 'Item 3'];

    $scope.status = {
        isCustomHeaderOpen: false,
        isFirstOpen: true,
        isFirstDisabled: false
    };

    $scope.dynamicPopover = {
        content: 'Hello, World!',
        templateUrl: 'popover',
        title: 'Title'
    };

    $scope.openModalDialog = function (size, id, min, max, $transtypename) {
        /*var parentElem = parentSelector ?
         angular.element($document[0].querySelector('.modal-demo ' + parentSelector)) : undefined;*/
        var deferred = $q.defer();

        var modalInstance = $uibModal.open({
            animation: true,
            ariaLabelledBy: 'modal-title',
            ariaDescribedBy: 'modal-body',
            templateUrl: 'modalDialog',
            controller: 'ModalInstanceCtrlDialog',
            backdrop: 'static',
            keyboard: false,
            scope: $scope,
            size: size,
            //appendTo: parentElem,
            resolve: {
                trans_id: function() {
                    return id
                },
                trans_min: function() {
                    return min
                },
                trans_max: function() {
                    return max
                },
                trans_type_name: function() {
                    return $transtypename
                }
            }
        });

        modalInstance.result.then(function (response) {
            ArrModalDialogOpened.pop();
            deferred.resolve(response);
            //alert('Modal success at:' + new Date());
        }, function (response) {
            deferred.reject(response);
            //alert('Modal dismissed at: ' + new Date());
        });

        return deferred.promise;
    };

    var ArrModalDialogOpened = [];
    $scope.ModalInstanceCtrlDialog = function ($scope, $uibModalInstance, $timeout, trans_id, trans_min, trans_max, trans_type_name) {
        ArrModalDialogOpened.push($uibModalInstance);

        $scope.transTypeName = trans_type_name;
        $scope.transTypeMin = trans_min;
        $scope.transTypeMax = trans_max;

        $scope.cancel = function ($modalDialogForm) {
             if (($modalDialogForm.number > trans_max) || ($modalDialogForm.number < trans_min)) {
                alert("valores fora dos limites de max e min");
                return;
             }
            $modalDialogForm.id = trans_id;
            $uibModalInstance.close($modalDialogForm);
        };
    };


    $scope.modal = [];
    $scope.modal_formTab = [];
    //https://stackoverflow.com/questions/36844064/dismiss-uibmodal-from-within
    $scope.openModalTask = function (size, id, flag, proc_type_id) {
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
                trans_id: function() {
                    return id
                },
                flag_inic_process: function() {
                    return flag
                },
                process_type_id: function() {
                    return proc_type_id
                }
            }
        }).result.then(function(result) {
            //Get triggers when modal is closed
            //alert(reason);
            $scope.modal = [];
            //$scope.modal_processTab = [];
            //$scope.modal_formTab = [];
            uploader.clearQueue();
            $scope.modal_formTab.length = 0;
            if ($scope.modal_processTab !== undefined)
                $scope.modal_processTab.length = 0;
            modal_i = 0;
            index1 = 0;
            alert("entrou closed");
        }, function(reason){
            //gets triggers when modal is dismissed.
            uploader.clearQueue();
            $scope.modal_formTab.length = 0;
            if ($scope.modal_processTab !== undefined)
                $scope.modal_processTab.length = 0;
            modal_i = 0;
            index1 = 0;
            alert("entrou dismissed");
        });
    };

    $scope.modalsArrData = [];
    var modal_i = 0;
    var index1 = 0;
    $scope.ModalInstanceCtrl = function ($scope, $uibModalInstance, $timeout, trans_id, flag_inic_process, process_type_id) {
        $scope.modal_formTab.relTypeExist = false;
        $scope.modal_processTab = [];
        $scope.modal_formTab.push({ tab :[], causalinks :[], types : []});
        //debugger;
        $scope.myTransID = trans_id;
        //$scope.index = index1++;
        var index_m = 0;
        var indexTabLocal = 0;

        $scope.processes = function() {
            $http.get(API_URL + "/dashboard/get_processes_of_tr/" + trans_id, {
                ignoreLoadingBar: false
            })
                .then(function (response) {
                    $scope.process = response.data;
                    console.log($scope.process);
                });
        };


        $scope.verParEntType = function ($id, $index, $indexTab) {
            $scope.showMessage = false;
            $scope.formChild($id, $index, $indexTab);
        };
        $scope.formChild = function($id, $index, $indexTab) {
            if ($id == null)
            {

            }
            else
            {
                $http.get(API_URL + "/dashboard/get_props_form_child/" + $id, {
                    ignoreLoadingBar: false
                })
                    .then(function (response) {
                        /*$scope.showMessage = true;
                        $scope.modal_formTab.relTypeExist = false;
                        $scope.modal_formTab.propsform = response.data;
                        $scope.myPropsform_ = $scope.modal_formTab.propsform;
                        $scope.myRelTypeExist_ = $scope.modal_formTab.relTypeExist;*/

                        $scope.modal_formTab[$index].tab[$indexTab].showMessage = true;
                        $scope.modal_formTab[$index].tab[$indexTab].relTypeExist_ = false;
                        $scope.modal_formTab[$index].tab[$indexTab].propsform_ = response.data;
                        $scope.modal_formTab[$index].tab[$indexTab].showBtnType_ = true;

                        console.log($scope.modal_formTab[$index].tab[$indexTab]);

                    }, function errorCalback(response) {
                        $scope.modal_formTab[$index].tab[$indexTab].showMessage = false;
                        $scope.modal_formTab[$index].tab[$indexTab].relTypeExist_ = null;
                        $scope.modal_formTab[$index].tab[$indexTab].propsform_ = null;
                        $scope.modal_formTab[$index].tab[$indexTab].showBtnType_ = null;
                    }).finally(function () {
                    // called no matter success or failure
                });
            }
        };

        var data;
        $scope.isUserInicExecOfTrans = function ($trans_id, $counter) {
            var deferred = $q.defer();

            if ($counter == 0)
            {
                $http.get(API_URL + "/dashboard/is_User_InicAndExec_trans/" + $trans_id, {
                    ignoreLoadingBar: false
                })
                    .then(function (response) {
                        data = response;
                        deferred.resolve(response);
                    }, function errorCalback(response) {
                        data = response;
                        deferred.reject(response);
                    }).finally(function () {
                    // called no matter success or failure
                });
            }
            else
            {
                deferred.resolve(data);
            }

            counter++;

            return deferred.promise;
        };

        $scope.isTrAndStWaitingForAnotherTr = function ($trans_type_id, $t_state_id, $process_id) {
            var deferred = $q.defer();

            $http({
                method: 'POST',
                url: API_URL + "/dashboard/isTrAndStWaitingForAnotherTr",
                data: $.param({ 't_state_id' : $t_state_id,
                        'transaction_type_id': $trans_type_id,
                        'process_id' : $process_id
                    }
                ),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                ignoreLoadingBar: false
            }).then(function (response) {
                deferred.resolve(response);
            }, function errorCalback(response) {
                deferred.reject(response);
            }).finally(function () {
                // called no matter success or failure
            });

            return deferred.promise;
        };

        $scope.getCausalLinksOfTr = function ($trans_type_id, $arr_t_states_id) {
            var deferred = $q.defer();

                $http({
                    method: 'POST',
                    url: API_URL + "/dashboard/get_causal_links_tr",
                    data: $.param({ 't_states_id' : $arr_t_states_id,
                            'transaction_type_id':$trans_type_id
                        }
                    ),
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    ignoreLoadingBar: false
                }).then(function (response) {
                        deferred.resolve(response);
                    }, function errorCalback(response) {
                        deferred.reject(response);
                    }).finally(function () {
                    // called no matter success or failure
                });

            return deferred.promise;
        };

        $scope.getTransTypeName = function ($trans_type_id) {
            var deferred = $q.defer();

            $http({
                method: 'GET',
                url: API_URL + "/transaction_types/get_trans_type_name/" + $trans_type_id,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                ignoreLoadingBar: false
            }).then(function (response) {
                deferred.resolve(response);
            }, function errorCalback(response) {
                deferred.reject(response);
            }).finally(function () {
                // called no matter success or failure
            });

            return deferred.promise;
        };

        var type = 1;
        var counter = 0;
        var counterTStatesCan = 0;
        $scope.showMessage = false;
        $scope.templatePath = 'tabChildFormTask';

        //$scope.modal.transaction.transaction_type_id;

        var fileExist = false;

        $scope.process_id=0;
        $scope.types = [];
        $scope.changeTabBoot = function ($id, $title, $templateurl, $tabnumber, $type, $process_id) {
            $scope.modal_formTab[index_m].process = $process_id; //se não for selecionado nenhum valor na selectbox o valor vem undefined, se selecionado vem null
            $scope.modal_formTab[index_m].transaction_type_id = $id;
            $scope.modal_formTab[index_m].process_type_id = process_type_id;
            //console.log($process_id.id);
            //alert("$id=" + $id);
            //debugger;
            if ($tabnumber == 1) {
                counterTStatesCan = 0;
                counter = 0;
            }

            $scope.myTransID = $id;
            $scope.myTabNumber = $tabnumber + 1;

            //guarda da recursividade
            if ($type == 6) {
                $type = 1;
                return;
            }

            $scope.tabs.splice($scope.activeTabIndex + 1);

            $scope.modal.transaction_type_id = $id;

            $scope.isTrAndStWaitingForAnotherTr($id, $type, $process_id != null ? $process_id.id : null).then(function (data) {
                $scope.isUserInicExecOfTrans($id, counter).then(function (data) {
                        //debugger;
                        if (data.data == true) {
                            isUserInicExec = data.data;
                            counterTStatesCan = 0;
                        }

                        if (counterTStatesCan == 0) {
                            counterTStatesCan++;

                            $scope.propsForm($id, $type, index_m).then(function (response) {
                                    //emptyRelTypeProp se for false entao existem propriedades para aquele tipo de relação ou
                                    //é do tipo reltype entao é necessario carregar as selectboxes das instancias das entidades
                                    if (response.data.emptyRelTypeProp === false || response.data.emptyRelType === false)
                                    {
                                        //$scope.modal_formTab.relTypeExist = true;
                                        reltype = true;
                                        //carregar as duas selectboxes
                                        var id = response.data.rel_type_id;
                                        $scope.loadEntities1(id);
                                        $scope.loadEntities2(id);
                                    }
                                    else
                                    {
                                        reltype = false;
                                        //$scope.modal_formTab.relTypeExist = false;
                                    }

                                    if (response.data.emptyEntTypeProp === false || response.data.emptyEntType === false)
                                    {
                                        enttype = true;
                                    }
                                    else
                                    {
                                        enttype = false;
                                    }

                                    //File verification
                                    for (var i=0; i < response.data.data.length; i++)
                                    {
                                        if (response.data.data[i].value_type === "file")
                                        {
                                            fileExist = true;
                                            break;
                                        }
                                        else
                                        {
                                            fileExist = false;
                                        }
                                    }

                                    //$scope.modal_formTab.push({ tab :[], causalinks :[]}); se forem varios modais é preciso fazer assim
                                    $scope.modal_formTab[index_m].tab.push({
                                        isEmptyEntTypeProp : response.data.emptyEntTypeProp,
                                        isEmptyRelTypeProp : response.data.emptyRelTypeProp,
                                        entTypeExist: enttype,
                                        relTypeExist: reltype,
                                        propsform: response.data.data,
                                        showBtnType: true,
                                        fileExist: fileExist,
                                        type:$type
                                    });

                                    growl.success('Loading done successfully.', {title: 'Success!', referenceId: index_m});
                                    $scope.showBtnType = true;
                                    $scope.types.push($type);
                                    $scope.mytype = ++$type; //tem de ser ++type senao nao coloca o valor incrementado na variable $scope.mytype
                                    $scope.myindexTab = indexTabLocal++;
                                    $scope.myindex = index_m;

                                    console.log($scope.modal_formTab);

                                    $scope.addTab($title, $templateurl);
                                    $timeout(function () {
                                        $scope.changeTabBoot($id, $title, $templateurl, ++$tabnumber, $scope.mytype, $process_id);
                                    }, 100);
                                }
                            ).catch(function (response) {
                                //debugger;
                                $scope.modal_formTab[index_m].tab.push({
                                    isEmptyEntTypeProp : response.data.emptyEntTypeProp,
                                    isEmptyRelTypeProp : response.data.emptyRelTypeProp,
                                    entTypeExist: response.data.emptyEntType != true,
                                    relTypeExist: response.data.emptyRelType != true,
                                    propsform: null,
                                    showBtnType: null,
                                    type:$type
                                });

                                if (response.status == 400) {
                                    indexTabLocal++;
                                    counterTStatesCan = 0;
                                    $scope.types.push($type);
                                    $scope.taberror.message = "Não existe formulário associado a este tipo de transacção";
                                    //$scope.addTab($title + " " + $type, "tabError");
                                    $timeout(function () {
                                        $scope.changeTabBoot($id, $title, $templateurl, ++$tabnumber, ++$type, $process_id); //nao pode ser $tabnumber++
                                    },100);
                                    /*$scope.taberror = [];
                                     $scope.taberror.message = "Não existe formulário associado a este tipo de transacção";
                                     $scope.addTab("Error","tabError");*/
                                }
                                else if (response.status == 401)
                                {
                                    growl.error('There is no properties linked to Ent Type or Rel Type!', {
                                        title: 'Erro!',
                                        referenceId: 80
                                    });

                                    $uibModalInstance.close();
                                }
                            });

                            //$scope.changeTabBoot($id, $title, $templateurl, ++$tabnumber, ++$type);
                        }
                        else {
                            growl.error('Can´t advance to the next transaction state.', {
                                title: 'Erro!',
                                referenceId: index_m
                            });
                        }
                    }
                ).catch(function (response) {
                    if (response.status == 400) {

                    }
                });
                //}
            }).catch(function (response) {
                //debugger;
                if (response.status == 400) {
                    growl.error('Can´t advance to the next transaction state, there are some transactions needeed to do it first.', {
                        title: 'Erro!',
                        referenceId: index_m
                    });
                }
            });
        };

        //inicializar o array das tabs
        $scope.tabs = [];
        //verificar se o tipo de transacção inicia um novo processo
        if (flag_inic_process === 1) //se sim então não aparece a tab para escolher um processo já existente
        {
            $scope.changeTabBoot(trans_id, 'Task', 'tabFormTask', 1, 1, null);
        }
        else //se não então aparece a tab para escolher um processo já existente
        {
            $scope.tabs = [{
                title: 'Process',
                templateUrl: 'tabProcess',
                disabled: false
            }];

            $scope.processes(); //carregar a dropdownlist com os processos existentes
        }


        $scope.taberror = [];

        $scope.addTab = function($title, $templateurl) {
            $scope.tabs.push({
                title: $title,
                templateUrl: $templateurl,
                disabled: false
            });

            $timeout(function(){
                $scope.activeTabIndex = ($scope.tabs.length - 1);
            });
        };

        $scope.verifCanUseProc = function($proc_id)
        {
            $http({
                method: 'POST',
                url: API_URL + "dashboard/verify_can_use_proc/",
                data: $.param({ 'process_id': $proc_id,
                        'transaction_type_id':trans_id
                    }
                ),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).then(function (response) {
                if (response.data === false)
                {
                    $scope.cantAdvance = true;
                    growl.error('It is not possible to use this process because the requirements are already met!!! Choose another process', {
                        title: 'Erro!',
                        referenceId: index_m
                    });
                }
                else
                {
                    $scope.cantAdvance = false;
                }
            });
        };

        $scope.save = function ($form_Tab) {
            //$scope.modal_formTab.push({ causalinks :[]});
            $scope.modal_formTab[index_m].types.push($scope.types);
                $scope.getCausalLinksOfTr(trans_id, $scope.types).then(function (response) {
                    var causallinks = response.data;
                    causallinks.forEach(function (item, i) {
                        $scope.openModalDialog('sm', causallinks[i].caused_t, causallinks[i].min, causallinks[i].max, item.caused_transaction.language[0].pivot.t_name).then(function (data) {
                                $scope.modal_formTab[index_m].causalinks.push({
                                    transaction_type_id: causallinks[i].caused_t,
                                    t_state_id: 1,
                                    numberofTrs: data.number
                                });

                                if (ArrModalDialogOpened.length === 0)
                                {
                                    $scope.sendData($scope.modal_formTab).then(function (response){
                                        $uibModalInstance.close('save');
                                    });
                                }
                        });
                    });
                }).catch(function (response) {
                    if (response.status === 400) {
                        $scope.sendData($scope.modal_formTab).then(function (response){
                            $uibModalInstance.close('save');
                        });
                    }
                });
            console.log($scope.modal_formTab);
        };

        $scope.sendData = function ($data) {
            var deferred = $q.defer();

            $http({
                method: 'POST',
                url: API_URL + "/dashboard/send_data",
                data: $data,
                headers: {'Content-Type': 'application/json'},
                ignoreLoadingBar: false
            }).then(function (response) {
                deferred.resolve(response);
            }, function errorCalback(response) {
                deferred.reject(response);
            }).finally(function () {
                // called no matter success or failure
            });

            return deferred.promise;
        };

        $scope.cancel = function () {
            $uibModalInstance.close('cancel');
        };
    };

    $scope.modal.transaction_type_id = null;

    var reltype = false;
    var enttype = false;
    $scope.propsForm = function($id, $type, $index)
    {
        var deferred = $q.defer();
        //$scope.modal_formTab = [];
        //$scope.modal_formTab.loading = true;
        $http.get(API_URL + "/dashboard/get_props_form/" + $id + "/" + $type)
            .then(function (response) {
                    deferred.resolve(response);
                }, function errorCalback(response)
                {
                    deferred.reject(response);
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

    $scope.transacsTypesUserCanInit_ = function() {
        $http.get(API_URL + "/dashboard/get_transtypeusercaninit_")
            .then(function (response) {
                $scope.transactiontypes_ = response.data;
            });
    };
    $scope.transacsTypesUserCanInit_();


    $scope.getAllInicExecTrans = function() {
        $http.get('/dashboard/get_all_inic_exec_trans', [{cache : true}]).then(function(response) {
            $scope.tableParamsInicTrans = new NgTableParams({
                count: 5,
                group: "process_type_name",
                sorting: { id: "desc" }
            }, {
                paginationMaxBlocks: 13,
                paginationMinBlocks: 2,
                dataset: response.data.InicTrans
            });

            $scope.tableParamsExecTrans = new NgTableParams({
                count: 5,
                group: "process_type_name",
                sorting: { id: "desc" }
            }, {
                paginationMaxBlocks: 13,
                paginationMinBlocks: 2,
                dataset: response.data.ExecTrans
            });
        });
    };
    $scope.getAllInicExecTrans();

    $scope.getInicTrans = function() {
        $http.get('/dashboard/get_all_inic_trans', [{cache : true}]).then(function(response) {
            $scope.tableParamsInicTrans = new NgTableParams({
                count: 5,
                group: "process_type_name",
                sorting: { id: "desc" }
            }, {
                paginationMaxBlocks: 13,
                paginationMinBlocks: 2,
                dataset: response.data
            });
        });
    };
    //$scope.getInicTrans();

    $scope.getExecTrans = function() {
        $http.get('/dashboard/get_all_exec_trans', [{cache : true}]).then(function(response) {
            $scope.tableParamsExecTrans = new NgTableParams({
                count: 5,
                group: "process_type_name",
                sorting: { id: "desc" }
            }, {
                paginationMaxBlocks: 13,
                paginationMinBlocks: 2,
                dataset: response.data
            });
        });
    };
    //$scope.getExecTrans();





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
        $scope.myTransID = trans_id;

        $scope.changeTabBoot_ = function ($id, $title, $templateurl, $tabnumber, $trans_type_id, $t_state_id) {
            $scope.tabs.splice(($scope.activeTabIndex + 1), ($scope.tabs.length - 1));

            alert($id + "," + $trans_type_id + "," + $t_state_id);

            if ($id !== undefined) {
                //$scope.addTab($title,$templateurl);
                switch ($tabnumber) {
                    case 1:
                        alert("Selected Case Number is 1");
                        $scope.verifyIfCanDoNextTransactionState($id, $t_state_id, $scope.actorCan, $title, $templateurl, $trans_type_id);
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

        $scope.verifyIfCanDoNextTransactionState = function($id, $t_state, $actorCan, $title, $templateurl, $trans_type_id) {
            MyService.verifyCanDoNextTransState($id, $t_state, $actorCan, $title, $templateurl, $trans_type_id).then(function (response) {
                //if (data.canAdvance === true) {
                    //$scope.modal_formTab = [];
                    var type = response.data.nextState;

                    //a guarda da recursividade
                    if (type > 5)
                    {
                        return;
                    }

                    alert("The next transaction state is: " + type);
                    //$t_state++;
                    $scope.propsForm($id,type).then(function(data) {
                            $scope.showBtnType = false;
                            $scope.mytype = type;
                            $scope.addTab($title,$templateurl);
                        }
                    ).catch(function(response){
                        if (response === 400)
                        {
                            //recursividade
                            $scope.verifyIfCanDoNextTransactionState($id, $t_state+1, $actorCan, $title, $templateurl);
                        }
                        else
                        {
                            $scope.taberror = [];
                            $scope.taberror.message = "Não existe formulário associado a este tipo de transacção";
                            $scope.addTab("Error","tabError");
                        }
                    });

                /*}
                else
                {
                    alert("Não pode seguir para o proximo passo");
                }*/
            }).catch(function (response) {
                    if (response.status === 400)
                    {
                        alert("Não pode seguir para o proximo passo");
                    }
                    else if (response.status === 401)
                    {
                        alert("Não existe entidade associada a transacção");
                    }
                    alert("erro");
                    console.log(response);
                });
        };

        $scope.trans_states = function($id) {
            $http.get(API_URL + "/dashboard/get_states_from_transaction/" + $id)
                .then(function (response) {
                    $scope.transactionstates = response.data.data;
                    //$scope.t_state_id = response.data.t_state_id;

                    var lastTransactionState = response.data.data[response.data.data.length-1];
                    if ((actor_Can === 'Iniciator') && (lastTransactionState.t_state_id === 2 || lastTransactionState.t_state_id === 3 || lastTransactionState.t_state_id === 4))
                    {
                        //verifica e insere na base de dados
                    }
                    else if ((actor_Can === 'Executer') && (lastTransactionState.t_state_id === 1 || lastTransactionState.t_state_id === 5))
                    {
                        //verifica e insere na base de dados
                    }
                });
        };
        $scope.trans_states(trans_id);

        $scope.insertTransactionAck = function($trans_state_id) {
            $http({
                method: 'POST',
                url: API_URL + "dashboard/verify_can_use_proc/",
                data: $.param({ 'process_id': $proc_id,
                        'transaction_type_id':trans_id,
                        'trans_state_id' : $trans_state_id
                    }
                ),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).then(function (response) {
                if (response.data === false)
                {
                    $scope.cantAdvance = true;
                    growl.error('It is not possible to use this process because the requirements are already met!!! Choose another process', {
                        title: 'Erro!',
                        referenceId: index_m
                    });
                }
                else
                {
                    $scope.cantAdvance = false;
                }
            });
        };

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

    $scope.values = {};
    //save new record / update existing record
    $scope.save = function(modalstate, id) {
        console.log($scope.values);
        /*var url = API_URL + "Transaction_Type";

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
        });*/
    };

    //FileUploader Functions
    var uploader = $scope.uploader = new FileUploader({
        url: 'fileUpload'
    });

    // CALLBACKS
    uploader.onWhenAddingFileFailed = function(item /*{File|FileLikeObject}*/, filter, options) {
        console.info('onWhenAddingFileFailed', item, filter, options);
    };
    uploader.onAfterAddingFile = function(fileItem) {
        var namePath = fileItem.file.name;
        //debugger;
        var arrayKeys = Object.keys($scope.files);
        console.log('arrayKeys',arrayKeys);
        var lastItem = arrayKeys[arrayKeys.length-1];
        console.log('lastItem', lastItem);
        /*var allInputs = document.getElementsByTagName("input");
        var result = null;
        for(var x=0;x<allInputs.length;x++)
        {
            if(allInputs[x].type === "file" && allInputs[x].files.length > 0)
            {
                if(allInputs[x].files[0].name === namePath)
                //result.push(allInputs[x]);
                    result = allInputs[x];
            }
        }*/

        //result.disabled = true;
        //var fileName = result.id;
        var fileName = lastItem;
        var fileExtension = '.' + fileItem.file.name.split('.').pop();
        var fileNameOriginal = fileItem.file.name;
        fileItem.file.name = fileName + fileExtension;

        var reader = new FileReader();
        reader.readAsDataURL(fileItem._file);
        reader.onload = function (event) {
            var base64 = event.target.result;
            fileItem.file['data'] = base64;
            fileItem.file['fileName'] = fileNameOriginal;
        };

        angular.forEach($scope.modal_formTab[0].tab, function(value, key1) {
            angular.forEach(value.propsform, function(value, key) {
                if (value.language[0].pivot.form_field_name === fileName)
                {
                    var obj = {};
                    obj[fileName] = fileItem.file;
                    value['fields'] = obj;
                }
            });
        });
        console.log('modaformtab', $scope.modal_formTab);
        console.log('onAfterAddingFile', fileItem);
    };
    $scope.files = [];
    uploader.onAfterRemovingFile = function(fileItem) {
        var fileName = fileItem.file.name.split('.').shift();
        //$scope.files[0][fileName] = null;
        delete $scope.files[fileName];

        var fileName = fileItem.file.name.replace(/\.\w+/, "");
        angular.forEach($scope.modal_formTab[0].tab, function(value, key1) {
            angular.forEach(value.propsform, function(value, key) {
                if (value.language[0].pivot.form_field_name === fileName)
                {
                    delete value['fields'];
                }
            });
        });
        console.info('onAfterRemovingFile', fileItem);
    };
    uploader.onAfterAddingAll = function(addedFileItems) {
        console.info('onAfterAddingAll', addedFileItems);
    };
    uploader.onBeforeUploadItem = function(item) {
        console.info('onBeforeUploadItem', item);
    };
    uploader.onProgressItem = function(fileItem, progress) {
        console.info('onProgressItem', fileItem, progress);
    };
    uploader.onProgressAll = function(progress) {
        console.info('onProgressAll', progress);
    };
    uploader.onSuccessItem = function(fileItem, response, status, headers) {
        console.info('onSuccessItem', fileItem, response, status, headers);
    };
    uploader.onErrorItem = function(fileItem, response, status, headers) {
        console.info('onErrorItem', fileItem, response, status, headers);
    };
    uploader.onCancelItem = function(fileItem, response, status, headers) {
        console.info('onCancelItem', fileItem, response, status, headers);
    };
    uploader.onCompleteItem = function(fileItem, response, status, headers) {
        console.info('onCompleteItem', fileItem, response, status, headers);
    };
    uploader.onCompleteAll = function() {
        console.info('onCompleteAll');
    };
}).directive('validFile', function () {
    return {
        require: "ngModel",
        restrict: 'A',
        link: function ($scope, el, attrs, ngModel) {
            el.bind('change', function (event) {
                ngModel.$setViewValue(event.target.files[0]);
                $scope.$apply();
            });

            $scope.$watch(function () {
                return ngModel.$viewValue;
            }, function (value) {
                console.log(value);
                if (!value) {
                    el.val("");
                }
            });
        }
    };
});