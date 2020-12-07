app.controller('UploadShipOrderController', function($scope, $http, $compile, $location, $routeParams) {

    $scope.dzOptions = {
        url: projectURL + '/upload/shiporder',
        paramName: 'file',
        maxFilesize: '10',
        dictDefaultMessage: "Arraste o arquivo xml aqui",
        addRemoveLinks: true,
        dictResponseError: 'Não foi possivel carregar o arquivo.'
    };
    $scope.change = function() {
        $http.get(projectURL + '/all/shiporder?&token=' + token)
            .success(function(data) {
                $scope.result = data;
            });
    }
    $scope.dzCallbacks = {
        'addedfile': function(file) {
            console.log(file);
            $('#errormodal').show()
            $scope.newFile = file;
        },
        'success': function(file, xhr) {
            console.log(file, xhr);
            $('#sucsseModal').show()
            $scope.change();
        },

    };
    $scope.sair = function() {
        $('.modalGeral').hide();
    }
    $scope.change();

});