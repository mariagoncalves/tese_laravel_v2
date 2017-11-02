
app.controller('rolesController', function($scope, $http, growl, API_URL, $translatePartialLoader, $translate, NgTableParams, MyService) {
    $translatePartialLoader.addPart('roles');

    setTimeout(function() { $translate.refresh(); }, 0);

    $scope.dotranslate = function() {
        var currentLang = $translate.proposedLanguage() || $translate.use();
        if (currentLang == "en")
            $translate.use('pt');
        else
            $translate.use('en');
    };

    $scope.type_class = "fa fa-fw fa-sort";
    $scope.type = 'ASC';
    $scope.input = null;
    $scope.num = null;
    var fil_sort = false;
    $scope.sort = function(input,num) {
        $scope.input = input;
        $scope.num = num;
        if ($scope.type == 'ASC' || $scope.type == 'DESC')
            fil_sort = true;

        if ($scope.type == 'ASC')
        {
            $scope.type_class = 'fa fa-fw fa-sort-asc';
            $scope.type = 'DESC';
        }
        else
        {
            $scope.type_class = 'fa fa-fw fa-sort-desc';
            $scope.type = 'ASC';
        }

        $scope.getRoles(input);
    };

    $scope.roles = function() {
        $http.get(API_URL + "/get_roles")
            .then(function (response) {
                $scope.roles = response.data;
            });
    };

    $scope.roles = [];
    $scope.role = [];
    $scope.totalPages = 0;
    $scope.currentPage = 1;
    $scope.range = [];
    $scope.selactors = [];
    $scope.selusers = [];
    $scope.selactors.selected = [];
    $scope.selusers.selected = [];

    var fil = false;
    $scope.filter = function() {
        var x = [ this.search_id, this.search_name, this.search_updated_at ];
        fil = MyService.filter(x);
        $scope.getRoles();
    };

    $scope.getRoles = function(pageNumber) {
        if (pageNumber === undefined) {
            pageNumber = '1';
        }
        var url='';
        if (fil === true)
        {
            if ($scope.search_id)
                url += '&s_id=' + $scope.search_id;

            if ($scope.search_name)
                url += '&s_name=' + $scope.search_name;

            if ($scope.search_updated_at)
                url += '&s_updated_at=' + $scope.search_updated_at;
        }

        if (fil_sort === true)
        {
            url += '&input_sort=' + $scope.input + '&type=' + $scope.type;
        }
        //Process_Type
        $http.get('/get_roles/?page='+pageNumber+url).then(function(response) {
            $scope.roles = response.data.data; //quando é procurado do processtypes para a linguagem
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
    $scope.toggle = function(modalstate, id) {
        $scope.modalstate = modalstate;
        switch (modalstate) {
            case 'add':
                $scope.id = id;
                break;
            case 'edit':
                $scope.id = id;
                $http.get(API_URL + 'get_roles/' + id)
                    .then(function(response) {
                        $scope.role = response.data;
                    });
                break;
            case 'remove':
                $scope.id = id;
                $http.get(API_URL + 'get_roles/' + id)
                    .then(function(response) {
                        $scope.role = response.data;
                    });
                break;

            case 'view_actors':
                $scope.id = id;
                $http.get(API_URL + 'get_roles/' + id)
                    .then(function(response) {
                        $scope.role = response.data;
                    });
                $http.get(API_URL + '/roles/get_selactors/' + id)
                    .then(function(response) {
                        $scope.selactors = response.data;
                    });
                break;
            case 'view_users':
                $scope.id = id;
                $http.get(API_URL + 'get_roles/' + id)
                    .then(function(response) {
                        $scope.role = response.data;
                    });
                $http.get(API_URL + '/roles/get_selusers/' + id)
                    .then(function(response) {
                        $scope.selusers = response.data;
                    });
                break;
            case 'add_actors':
                $scope.id = id;
                $http.get(API_URL + 'get_roles/' + id)
                    .then(function(response) {
                        $scope.role = response.data;
                    });
                $http.get(API_URL + '/roles/get_actors')
                    .then(function(response) {
                        $scope.actors = response.data;
                    });
                $http.get(API_URL + '/roles/get_onlyactors/' + id)
                    .then(function(response) {
                        $scope.selactors.selected = response.data;
                    });
                break;

            case 'add_users':
                $scope.id = id;
                $http.get(API_URL + 'get_roles/' + id)
                    .then(function(response) {
                        $scope.role = response.data;
                    });
                $http.get(API_URL + '/roles/get_users')
                    .then(function(response) {
                        $scope.users = response.data;
                    });
                $http.get(API_URL + '/roles/get_onlyusers/' + id)
                    .then(function(response) {
                        $scope.selusers.selected = response.data;
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

    $scope.removeactor = function(roleid, actorid) {
        var url = API_URL + "remove_actor_role/";
        $http({
            method: 'POST',
            url: url,
            data: $.param(
                {
                    'role_id' : roleid,
                    'actor_id' : actorid,
                }
            ),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            //headers: {'Content-Type': 'json'}
        }).then(function (response) {
            growl.success('Your Request Was Successfully Completed.',{title: 'Success!'});

            $http.get(API_URL + '/roles/get_selactors/' + roleid)
                .then(function(response) {
                    $scope.selactors = response.data;
                });

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

    $scope.removeuser = function(roleid, userid) {
        var url = API_URL + "remove_user_role/";
        $http({
            method: 'POST',
            url: url,
            data: $.param(
                {
                    'role_id' : roleid,
                    'user_id' : userid,
                }
            ),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            //headers: {'Content-Type': 'json'}
        }).then(function (response) {
            growl.success('Your Request Was Successfully Completed.',{title: 'Success!'});

            $http.get(API_URL + '/roles/get_selusers/' + roleid)
                .then(function(response) {
                    $scope.selusers = response.data;
                });

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
        var url = API_URL + "roles";
        if (modalstate === 'remove') {
            url += "/remove/" + id;
        }
        if (modalstate === 'edit') {
            url += "/" + id;
        }
        if(modalstate === 'add_actors') {
            url += "/update_actors/" + id;
            $http({
                method: 'POST',
                url: url,
                data: $.param(
                    {
                        'role_id' : $scope.role.id,
                        'selectedActors': $scope.selactors.selected,
                    }
                ),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).then(function (response) {
                growl.success('Your Request Was Successfully Completed.',{title: 'Success!'});
                $scope.toggle('view_actors', id);
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
        } else if (modalstate === 'add_users') {
            url += "/update_users/" + id;
            $http({
                method: 'POST',
                url: url,
                data: $.param(
                    {
                        'role_id' : $scope.role.id,
                        'selectedUsers' : $scope.selusers.selected,
                    }
                ),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).then(function (response) {
                growl.success('Your Request Was Successfully Completed.',{title: 'Success!'});
                $scope.toggle('view_users', id);
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
        } else {
            $http({
                method: 'POST',
                url: url,
                data: $.param(
                    {
                        'role_id': $scope.role.id,
                        'name': $scope.role.name,
                    }
                ),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).then(function (response) {
                growl.success('Your Request Was Successfully Completed.', {title: 'Success!'});
                $('#myModal').modal('hide');
                $scope.getRoles();
            }, function errorCallback(response) {
                if (response.status == 400) {
                    growl.error('This is error message.', {title: 'error!'});
                }
                else {
                    $scope.errors = response.data;
                }
            });
        }
    };

}).directive('postsPagination', function(){
    return{
        restrict: 'E',
        template: '<ul class="pagination">'+
        '<li ng-show="currentPage != 1"><a href="javascript:void(0)" ng-click="getRoles(1)">&laquo;</a></li>'+
        '<li ng-show="currentPage != 1"><a href="javascript:void(0)" ng-click="getRoles(currentPage-1)">&lsaquo; Prev</a></li>'+
        '<li ng-repeat="i in range" ng-class="{active : currentPage == i}">'+
        '<a href="javascript:void(0)" ng-click="getRoles(i)">{{i}}</a>'+
        '</li>'+
        '<li ng-show="currentPage != totalPages"><a href="javascript:void(0)" ng-click="getRoles(currentPage+1)">Next &rsaquo;</a></li>'+
        '<li ng-show="currentPage != totalPages"><a href="javascript:void(0)" ng-click="getRoles(totalPages)">&raquo;</a></li>'+
        '</ul>'
    };
});