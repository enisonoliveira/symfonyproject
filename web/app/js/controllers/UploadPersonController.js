app.controller('UploadPersonController', function($scope, $http, $compile, $location, $routeParams) {

    $scope.form1 = {}
    $scope.form = {}


    $scope.dzOptions = {
        url: projectURL + '/upload/person',
        paramName: 'file',
        maxFilesize: '10',
        dictDefaultMessage: "Arraste sua foto para cá ou click aqui e selecione uma foto do seu computador",
        addRemoveLinks: true,
        dictResponseError: 'Não foi possivel carregar o arquivo.'
    };

});