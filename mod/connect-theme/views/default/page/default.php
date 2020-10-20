<?php
/**
 * Elgg pageshell
 * The standard HTML page shell that everything else fits into
 *
 * @package Elgg
 * @subpackage Core
 *
 * @uses $vars['head']        Parameters for the <head> element
 * @uses $vars['body_attrs']  Attributes of the <body> tag
 * @uses $vars['body']        The main content of the page
 * @uses $vars['sysmessages'] A 2d array of various message registers, passed from system_messages()
 */

// render content before head so that JavaScript and CSS can be loaded. See #4032

$messages = elgg_view('page/elements/messages', array('object' => $vars['sysmessages']));

$header = elgg_view('page/elements/header', $vars);
$navbar = elgg_view('page/elements/navbar', $vars);
$content = elgg_view('page/elements/body', $vars);
$footer = elgg_view('page/elements/footer', $vars);
$site_url = elgg_get_site_url();
$site = elgg_get_site_entity();
$site_name = $site->name;
 
$user = elgg_get_logged_in_user_entity();

?>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo $site_name; ?></title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="<?php echo $site_url?>mod/connect-theme/vendors/assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="<?php echo $site_url?>mod/connect-theme/vendors/assets/vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="<?php echo $site_url?>mod/connect-theme/vendors/assets/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="<?php echo $site_url?>mod/connect-theme/vendors/assets/vendors/font-awesome/css/font-awesome.min.css" />
    <link rel="stylesheet" href="<?php echo $site_url?>mod/connect-theme/vendors/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="<?php echo $site_url?>mod/connect-theme/vendors/assets/css/style.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="<?php echo $site_url?>mod/connect-theme/vendors/assets/images/favicon.png" />
    <?php echo elgg_view('page/elements/head', $vars['head']);?>
  </head>
  <body>
    <div class="container-scroller">
      <!-- partial:partials/_navbar.html -->
       <?php
            echo elgg_view('page/elements/connect-navbar');
        ?>
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
         
        <div class="main-panel">
          <div class="content-wrapper">
            
            
            <div class="row">
              <div class="col-md-12">
                 
                  
                <div class="tab-content tab-transparent-content">
                  <div class="tab-pane fade show active" id="business-1" role="tabpanel" aria-labelledby="business-tab">
                     
                    <div class="row">
                      <div class="col-12 grid-margin">
                        <div class="card">
                          <div class="card-body">
                            <div class="row">
                              
                                
                             
                              <div class="col-lg-12 col-sm-8 grid-margin  grid-margin-lg-0">
                                <div class="pl-0 pl-lg-4 ">
                                  <div class="d-xl-flex justify-content-between align-items-center mb-2">
                                     
                                     
                                  </div>
                                  <?php echo $content ?>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- content-wrapper ends -->
          <!-- partial:partials/_footer.html -->
          <?php
                echo elgg_view('page/elements/connect-footer');
          ?>
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="<?php echo $site_url?>mod/connect-theme/vendors/assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="<?php echo $site_url?>mod/connect-theme/vendors/assets/vendors/chart.js/Chart.min.js"></script>
    <script src="<?php echo $site_url?>mod/connect-theme/vendors/assets/vendors/jquery-circle-progress/js/circle-progress.min.js"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="<?php echo $site_url?>mod/connect-theme/vendors/assets/js/off-canvas.js"></script>
    <script src="<?php echo $site_url?>mod/connect-theme/vendors/assets/js/hoverable-collapse.js"></script>
    <script src="<?php echo $site_url?>mod/connect-theme/vendors/assets/js/misc.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="<?php echo $site_url?>mod/connect-theme/vendors/assets/js/dashboard.js"></script>
    <?php echo elgg_view('page/elements/foot');?>
    <!-- End custom js for this page -->
  </body>
</html>