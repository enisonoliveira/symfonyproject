 app = angular.module('api', []);
 app.controller('clienteCtrl', function($scope, $http, $compile) {
     //    $scope.change = function () {
     var ip = "";
     $http.get("https://api.ipify.org/?format=json").then(function(response) {
         console.log(response.data.ip);
         ip = response.data.ip;

     });
     //    };


     $scope.keycod = function(e) {
         if (e.keyCode === 13) {
             return $scope.logar();
         }
     }
     $scope.keypressrecuperar = function(e) {
         if (e.keyCode === 13) {
             return $scope.recuperar_senha();
         }
     }
     $scope.keycodsenha = function(e) {
         if (e.keyCode === 13) {
             return $scope.logar_senha(e);
         }
     }



     this.password = "";
     //    this.email = "";
     $scope.logar_senha = function() {
         var pass = $('#password').val();
         var email = $('#email').val();
         if (pass == '' | email == '') {
             $("#mensagem").text('Por favor, insira a sua senha e usuário.');
             $('#mensagem').addClass('error');
             $('#password').addClass('invalid');
             $('#email').addClass('invalid');
             $('#preLoadLogin').hide();
             return false;
         } else {
             $('#preLoadLogin').show();
         }

         $http.get('/validarsenha?password=' + this.password + '&email=' + $scope.email + '&certificado=' + 'token' + '&ip=' + ip)
             .success(function(data) {
                 $('#preLoad').hide();
                 localStorage.setItem("tokenval", data.token);
                 localStorage.setItem("logado", 1);
                 localStorage.setItem("pagina", data.pagina);
                 localStorage.setItem("emailcli", $scope.email);
                 localStorage.setItem("iduser", data.iduser);
                 localStorage.setItem("ip", ip);
                 var url = "/app/!#";
                 location.replace(url);
             })
             .error(function(data) {
                 $('#password').addClass('invalid');
                 $("#mensagem").text(data.message);
                 $('#mensagem').addClass('error');
                 $('#preLoadLogin').hide();
                 return [];
             });

     };
     $("a[href='#recuperar']").on('click', function(e) {
         $('.box .form .title').html('<span class="recover">Recuperar senha</span>');
         $('#formLogin').addClass('hidden');
         $('#formLogin').removeClass('active');
         $('#formSenha').addClass('active');
         $('#formSenha').removeClass('hidden');
         e.preventDefault();
     });
     $("a[href='#voltar']").on('click', function(e) {
         $('.box .form .title').html('<span>Login de Assinante</span>');
         $('#formLogin').addClass('active');
         $('#formLogin').removeClass('hidden');
         $('#formSenha').addClass('hidden');
         $('#formSenha').removeClass('active');
         e.preventDefault();
     });
 });
 $('#login input').blur(function() {
     if (!$(this).val()) {
         $(this).addClass('invalid');
     } else {
         $(this).removeClass('invalid');
     }


 });