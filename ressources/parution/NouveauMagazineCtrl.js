
dashboard.controller("NouveauMagazineCtrl", ['$rootScope', '$scope', '$state', '$timeout', 'startupService','appSettings',
function ($rootScope, $scope, $state, $timeout, startupService,appSettings) {
    //var vm = this;
       // alert('Check console log.');
       $scope.magasine={}
      $scope.showBtns = false;
      $scope.lastFile = null;

    var apiBase = 'http://startupapps.businessroom.ci/api/v1/';
      console.log(apiBase)

      var parution={num_parution:'',titre:'',img:[]}
      var img={}

      $scope.getDropzone = function(){

        console.log($scope.dzMethods.getDropzone());

        //alert('Check console log.');
      };

      $scope.getFiles = function(){

        console.log($scope.dzMethods.getAllFiles());

        //alert('Check console log.');
      };

    $scope.valider=function()
      {

        if (!$scope.magasine.titre || !$scope.magasine.numero) {
          // statement
          return
        }
        img=$scope.dzMethods.getAllFiles()
        //console.log(img)
        parution.img=[]

        angular.forEach(img, function(value) {
          parution.img.push({'name':value.name})
          //console.log(value.name)
        });

        parution.num_parution=$scope.magasine.numero
        parution.titre=$scope.magasine.titre

         console.log(parution)
      startupService.SaveParution(parution).then(function(response)
          {
            console.log(response)
            if (response.error==false) {

              // statement
              $scope.dzOptions.parallelUploads=parution.img.length
               /*  $scope.dzOptions.params.numero=$scope.magasine.numero*/
                 $scope.dzMethods.processQueue();

            }else {
              alertify.error("vérifier votre connexion SVP")
              return
            }
          })
       
      }
      $scope.dzOptions = {
        url : apiBase+'web/upload.php',
        dictDefaultMessage : '  Cliquer ou glisser-déposer les images ICI',
        acceptedFiles : 'image/jpeg,images/png,images/jpg,',
        parallelUploads: 2,
        uploadMultiple: true,
        maxFilesize: 256,
        //params :{titre:'',numero:''}
        autoProcessQueue : false
      };
      
      $scope.dzMethods = {};
      
      $scope.dzCallbacks = {
        'addedfile' : function(file){
          $scope.showBtns = true;
          $scope.lastFile = file;
        },
        'error' : function(file, xhr){
          console.warn('File failed to upload from dropzone 2.', file, xhr);
        }
      };

}]);

