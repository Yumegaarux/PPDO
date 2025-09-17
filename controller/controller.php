<?php
    require('view/session.php');
    class Controller {

        public $model = null;

        function __construct(){
            include_once("model/managePlantAndFish.php");
            $this->model = new Management();
        }

        public function getWeb() {
            $page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
            switch ($page) {
                case 'dashboard':
                    include("view/dashboard.php");
                    break;

                case 'control':
                    $plants = $this->model->getPlant();
                    $fishes = $this->model->getFish();
                    include("view/control.php");
                    break;

                case 'selection':
                    $plantSelection = $_GET['plantID'] ?? null;
                    $fishSelection = $_GET['fishID'] ?? null;

                    if(isset($plantSelection)) {
                        $_SESSION['plantSelection'] = $plantSelection;
                        echo "<script>window.location.href='index.php?page=control&plantID=$plantSelection'</script>";
                    }

                    if(isset($fishSelection)) {
                        $_SESSION['fishSelection'] = $fishSelection;
                        echo "<script>window.location.href='index.php?page=control&fishID=$fishSelection'</script>";
                    }
                    break;

                case 'cancelSelection':
                    $_SESSION['plantSelection'] = null;
                    $_SESSION['fishSelection'] = null;

                    echo "<script>window.location.href='index.php?page=control'</script>";
                    break;

                case 'archive':
                    include("view/archive.php");
                    break;

                case 'helpdesk':
                    include("view/helpdesk.php");
                    break;

                case 'addPlant':
                    $plantName = $_REQUEST['pName'];
                    $minSTol = $_REQUEST['minSTol'];
                    $maxSTol = $_REQUEST['maxSTol'];
                    $minpHTol = $_REQUEST['minpHTol'];
                    $maxpHTol = $_REQUEST['maxpHTol'];
                    $seedStage = $_REQUEST['seedlingStage'];
                    $seedFreq = $_REQUEST['seedlingFrequency'];
                    $seedCyc = $_REQUEST['seedlingCycle'];
                    $vegStage = $_REQUEST['vegetativeStage'];
                    $vegFreq = $_REQUEST['vegetativeFrequency'];
                    $vegCyc = $_REQUEST['vegetativeCycle'];
                    $matureStage = $_REQUEST['matureStage'];
                    $matureFreq = $_REQUEST['matureFrequency'];
                    $matureCyc = $_REQUEST['matureCycle'];

                    if(!empty($_FILES["fileToUpload"]["name"])){
                        $imageUpload=basename($_FILES["fileToUpload"]["name"]);
                        
                        $imagePath="img_upload/". $imageUpload;
                        
                        $imageFileType = strtolower(pathinfo($imagePath,PATHINFO_EXTENSION));
                        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);

                        $err = $this->model->checkImageUpload($check,$imageFileType,$imagePath,1);
                    }
                    else{
                        $err = 'No Image Selected';
                    }
                    
                    if($err=="K" )
                    {
                        $result = $this->model->addPlant($plantName, $minSTol, $maxSTol, $minpHTol, $maxpHTol, $seedStage, $seedFreq, $seedCyc,
                                                     $vegStage, $vegFreq, $vegCyc, $matureStage, $matureFreq, $matureCyc, $imagePath);
                        echo "<script> alert('".$result."'); window.location.href='index.php?page=control' </script>";
                    }
                    else
                    {
                        echo "<script> alert ('".$err."'); window.location.href='index.php?page=control' </script>"; 
                    }

                    break;

                case 'addFish':
                    $fishName = $_REQUEST['fName'];
                    $minSTol = $_REQUEST['minSTol'];
                    $maxSTol = $_REQUEST['maxSTol'];
                    $minpHTol = $_REQUEST['minpHTol'];
                    $maxpHTol = $_REQUEST['maxpHTol'];
                    $fRate = $_REQUEST['fingerlingRate'];
                    $fAvgBodyWeight = $_REQUEST['fingerlingAvgBodyWeight'];
                    $fFrequency = $_REQUEST['fingerlingFrequency'];
                    $fStage = $_REQUEST['fingerlingStage'];
                    $jRate = $_REQUEST['juvenileRate'];
                    $jAvgBodyWeight = $_REQUEST['juvenileAvgBodyWeight'];
                    $jFrequency = $_REQUEST['juvenileFrequency'];
                    $jStage = $_REQUEST['juvenileStage'];
                    $aRate = $_REQUEST['adultRate'];
                    $aAvgBodyWeight = $_REQUEST['adultAvgBodyWeight'];
                    $aFrequency = $_REQUEST['adultFrequency'];
                    $aStage = $_REQUEST['adultStage'];

                    if(!empty($_FILES["fileToUpload"]["name"])){
                        $imageUpload=basename($_FILES["fileToUpload"]["name"]);
                        
                        $imagePath="img_upload/". $imageUpload;
                        
                        $imageFileType = strtolower(pathinfo($imagePath,PATHINFO_EXTENSION));
                        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);

                        $err = $this->model->checkImageUpload($check,$imageFileType,$imagePath,1);
                    }
                    else{
                        $err = 'No Image Selected';
                    }
                    
                    if($err=="K" )
                    {
                        $result = $this->model->addFish($fishName, $minSTol, $maxSTol, $minpHTol, $maxpHTol, $fRate, $fAvgBodyWeight, $fFrequency,
                                                     $fStage, $jRate, $jAvgBodyWeight, $jFrequency, $jStage, $aRate, $aAvgBodyWeight, $aFrequency, $aStage, $imagePath);
                        echo "<script> alert('".$result."'); window.location.href='index.php?page=control' </script>";
                    }
                    else
                    {
                        echo "<script> alert ('".$err."'); window.location.href='index.php?page=control' </script>"; 
                    }

                    break;

                case 'managePlant':
                    $plants = $this->model->getPlant();
                    include("view/managePlant.php");
                    break;

                case 'manageFish':
                    $fishes = $this->model->getFish();
                    include("view/manageFish.php");
                    break;

                default:
                    include("view/dashboard.php");
                    break;
            }
        }
    }
?>