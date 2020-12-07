
app.controller('UserController', function ($scope, $http, $location, $routeParams, $compile) {

    $('body').removeClass('alertOpen');
    $('body').removeClass('userOpen');
    $('#menuAnchor').removeClass('open');
    $('body').removeClass('searchOpen');
    $('body').removeClass('alertOpen');
    $('body').removeClass('menuOpen');
    $('#menuAnchor').removeClass('open');
    $('#closeMenu').removeClass('opacity');
    $('#closeMenu').removeClass('open');
    $('nav#menu > ul > li.has-children').removeClass('open');
    totalrow=0;
    $scope.pageSelected = 0;
    var ligado=false;
    var pagination = 10;

    $scope.report= function(){
        $location.path('/database').search({key: 'user_Table',name:"Operadores"});
    }
    
    $http.get(projectURL + '/user/getAll?limit1=' + 0 + "&limit2=" + pagination+"&token="+token)
        .success(function (data) {
            $scope.users = data;
            if(data.lenght>0){
                $scope.changePagenator(data[0].totalrow);
            }
        });
        
    var limit1 = 100;

    $scope.form = {
        name: "",
        iduser: '0',
        password: "",
        email: "",
        phone: "",
        passwordverifier: "",
        description: "comum"
    };

    $scope.new = function (event) {
        event.preventDefault();
        $scope.form.name = "";
        $scope.form.password = "";
        $scope.form.email = "";
        $scope.form.phone = "";
        $scope.form.passwordverifier = "";
        $scope.form.description = "";
        $scope.form.iduser = "";
        $scope.data = {
            primary: false
        };
    }

    $scope.setUser = function (user) {
        $location.path('/updateuser').search(jQuery.param(user));;

    }

    $scope.loadMore = function (page) {
        if (typeof page !== 'undefined') {
            console.log(page.page);
            console.log(page);
            $scope.pageSelected = page.page;
            limit1 = limit1 + 100;
            $http.get(projectURL + '/user/getAll?limit1=' + page.index + "&limit2=" + pagination+"&token="+token)
                .success(function (data) {
                    $scope.users = data;
                });
            $('a').removeClass('active');
            $('.a_' + page.page).addClass('active');
        }

    }
    
    if ($routeParams.iduser != null|$routeParams.id) {
        $scope.form.name = $routeParams.name;
        $scope.form.password = $routeParams.password
        if($routeParams.id){
            $scope.form.iduser = $routeParams.id;
        }else{
            $scope.form.iduser = $routeParams.iduser;
        }
        $scope.form.email = $routeParams.email;
        $scope.form.phone = $routeParams.phone;
        $scope.form.passwordverifier = $routeParams.password;
        $scope.form.description = $routeParams.description;
        if ($routeParams.description === 'Master') {
            $scope.form.data = {
                primary: true
            };
            ligado = true;
            $scope.form.description = "Master";
        } else {
            ligado = false;
            $scope.form.data = {
                primary: false
            }
            $scope.form.description = "comum";
        };
    }
  
    $scope.delete = function (iduser) {
        $http.get(projectURL + '/user/delete?iduser=' + iduser+"&token="+token)
            .success(function (data) {
                $http.get(projectURL +'/user/getAll?limit1=' + 0 + "&limit2=" + pagination+"&token="+token)
                    .success(function (data) {
                        $("#sucessomodal").show();
                        $scope.users = data;
                    }).error(function (data) {
                        $(".errormodal").show();
                    });
            })
    }

    $scope.perfil = function (e) {
        $('#preLoadBodySpiner').hide();
        if (ligado) {
            $scope.form.data = {
                primary: false
            };
            ligado = false;
            $scope.form.description = "comum";
        } else {
            ligado = true;
            $scope.form.data = {
                primary: true
            }
            $scope.form.description = "Master";
        }
    }
   
    $scope.validateForm = function () {
        if ($scope.form.name == '') {
            $("#name").addClass('error');
            alert("Informe o campo nome");
            return false;
        } else {
            if ($scope.form.passwordverifier == '') {
                $("#passwordverifier").addClass('error');
                alert("Informe o campo passwordverifier");
                return false;
            } else {
                if ($scope.form.password == '') {
                    $("#password").addClass('error');
                    alert("Informe o campo password e confirmação de senha corretamente!");
                    return false;
                } else {
                    if ($scope.form.phone == '') {
                        $("#phone").addClass('error');
                        alert("Informe o campo phone");
                        return false;
                    } else {
                        if($scope.form.password!=$scope.form.passwordverifier ){
                            alert("Confirmação de senha inválida");
                        }
                        return true;
                    }
                }
            }
        }
        return true;
    }
    
    $scope.submit = function ($event) {
        if ($scope.validateForm()) {
            $http.get(projectURL + '/user/save?' + jQuery.param($scope.form)+"&token="+token).success(function (data) {
                $("#sucessomodal").show();
            }).error(function (data) {
                $(".errormodal").show();
            });
        }
    }

    $scope.update = function ($event) {
        if ($scope.validateForm()) {
            $http.get(projectURL + '/user/update?' + jQuery.param($scope.form)+"&token="+token).success(function (data) {
                $("#sucessomodal").show();
            }).error(function (data) {
                $(".errormodal").show();
            });
        }
    }
    
    $scope.sair = function () {
        $(".modalGeral").hide();
    }
   
    $scope.paginator = [];
    
    $scope.changePagenator = function (totalRow) {
        totalRow = totalRow / pagination;
        console.log(totalRow);
        var a = 0;
        for (var i = 0; i <= totalRow; i++) {
            $scope.paginator.push({
                page: a,
                index: a * pagination,
                totalPage: a * pagination + pagination,
            })
            a++;
        }
        console.log($scope.paginator);
    }
});