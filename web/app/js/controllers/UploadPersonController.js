app.controller('UploadPersonController', function($scope, $http, $compile, $location, $routeParams) {

    $scope.form1 = {}
    $scope.form = {}

    $scope.dzOptions = {
        url: projectURL + '/upload/person',
        paramName: 'file',
        maxFilesize: '10',
        dictDefaultMessage: "Arraste o arquio xml aqui",
        addRemoveLinks: true,
        dictResponseError: 'Não foi possivel carregar o arquivo.'
    };

    $scope.dzCallbacks = {
        'addedfile': function(file) {
            console.log(file);
            $('#errormodal').show()
        },
        'success': function(file, xhr) {
            console.log(file, xhr);
            $('#sucsseModal').show()
            $scope.change();
        },
    };

    $scope.change = function() {
        $http.get(projectURL + '/all/person?&token=' + token)
            .success(function(data) {
                $scope.result = data;
            });
    }
    $scope.sair = function() {
        $('.modalGeral').hide();
    }
    $scope.change();
});