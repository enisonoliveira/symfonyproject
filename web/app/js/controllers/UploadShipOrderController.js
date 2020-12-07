app.controller('UploadShipOrderController', function($scope, $http, $compile, $location, $routeParams) {
    $scope.dzOptions = {
        url: projectURL + '/upload/shiporder',
        paramName: 'file',
        maxFilesize: '10',
        dictDefaultMessage: "Arraste sua foto para cá ou click aqui e selecione uma foto do seu computador",
        addRemoveLinks: true,
        dictResponseError: 'Não foi possivel carregar o arquivo.'
    };

});