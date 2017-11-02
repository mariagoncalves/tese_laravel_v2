/**
 * Created by ASUS on 26/05/2017.
 */
app.controller('processesController', function($scope, $http, growl, API_URL) {
    //retrieve employees listing from API
    /*$scope.refresh = function() {
        $http.get(API_URL + "Process_Type")
            .then(function (response) {
                $scope.processtypes = response.data;
            });
    };*/

    $scope.langs = function() {
        $http.get(API_URL + "/proc_types/get_langs")
            .then(function (response) {
                $scope.langs = response.data;
            });
    };

    $scope.procstypes = function() {
        $http.get(API_URL + "/proc_types/get_procs_types")
            .then(function (response) {
                $scope.processtypes = response.data;
            });
    };


    $scope.processtypes = [];
    $scope.totalPages = 0;
    $scope.currentPage = 1;
    $scope.range = [];

    $scope.getProcs = function(pageNumber) {

        if (pageNumber === undefined) {
            pageNumber = '1';
        }
        //Process_Type
        $http.get('/procs/get_procs?page='+pageNumber).then(function(response) {
            $scope.processes = response.data.data; //quando é procurado do processtypes para a linguagem
            //$scope.processtypes = response.data.data[0].process_type; quando é procurado da linguagem para o processtypes
            //alert(response.data.data[0].language[0].pivot.name);
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

    $scope.procstypes();
    $scope.langs();
    //show modal form
    $scope.toggle = function(modalstate, id) {
        $scope.modalstate = modalstate;

        switch (modalstate) {
            case 'add':
                $scope.id = id;
                $scope.form_title = "Adicionar Novo Processo";
                break;
            case 'edit':
                $scope.form_title = "Detalhes do Processo";
                $scope.id = id;
                $http.get(API_URL + 'procs/get_procs/' + id)
                    .then(function(response) {
                        $scope.process = response.data;
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


    //save new record / update existing record
    $scope.save = function(modalstate, id) {
        var url = API_URL + "Process";

        //append employee id to the URL if the form is in edit mode
        if (modalstate === 'edit') {
            url += "/" + id;
        }

        $http({
            method: 'POST',
            url: url,
            data: $.param({ 'language_id' : $scope.process.language[0].id,
                'name': $scope.process.language[0].pivot.name,
                'process_type_id': $scope.process.process_type_id,
                'state': $scope.process.state}
                ),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            //headers: {'Content-Type': 'json'}
        }).then(function (response) {
            growl.success('This is success message.',{title: 'Success!'});
            $('#myModal').modal('hide');
            $scope.getProcs();
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
        '<li ng-show="currentPage != 1"><a href="javascript:void(0)" ng-click="getProcs(1)">&laquo;</a></li>'+
        '<li ng-show="currentPage != 1"><a href="javascript:void(0)" ng-click="getProcs(currentPage-1)">&lsaquo; Prev</a></li>'+
        '<li ng-repeat="i in range" ng-class="{active : currentPage == i}">'+
        '<a href="javascript:void(0)" ng-click="getProcs(i)">{{i}}</a>'+
        '</li>'+
        '<li ng-show="currentPage != totalPages"><a href="javascript:void(0)" ng-click="getProcs(currentPage+1)">Next &rsaquo;</a></li>'+
        '<li ng-show="currentPage != totalPages"><a href="javascript:void(0)" ng-click="getProcs(totalPages)">&raquo;</a></li>'+
        '</ul>'
    };
});