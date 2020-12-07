app.controller('MainController', function ($scope, $http, $compile, $location) {
        $scope.listar_todos = function (page, event, title, paramter) {
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

                event.preventDefault();
                $location.path(page).search({site:paramter});

        }

        $scope.sair=function(){
        window.location.href='/login.html';
      }
        $http.get(projectURL + '/user/getUser?iduser=' + iduser+"&token="+token)
                .success(function (data) {
                        $scope.datauser = data;
                });

        $scope.dateAcess = function (dateAcess) {
                var date = new Date(dateAcess);
                sMonth = date.getMonth() + 1;
                if (sMonth < 10)
                        sMonth = "0" + sMonth;
                sDay = date.getDate();
                if (sDay < 10)
                        sDay = "0" + sDay;
                sYear = date.getFullYear();
                sHour = date.getHours();
                if (sHour < 10)
                        sHour = "0" + sHour;
                sMinute = date.getMinutes();
                if (sMinute < 10)
                        sMinute = "0" + sMinute;
                        
                return sDay + '/' + sMonth + '/' + sYear + ' ' + sHour + ':' + sMinute;
        }
});