<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$site_url = elgg_get_site_url();
$site = elgg_get_site_entity();
$site_name = $site->name;
 
$user = elgg_get_logged_in_user_entity();
?>
<nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
       
        <div class="navbar-menu-wrapper d-flex align-items-stretch">
          <a class="navbar-toggler navbar-toggler align-self-center" href="<?php echo $site_url ?>" style="font-size: 28px; margin-top: 30px;" >
            <span class="mdi mdi-tooltip-text"></span>
          </a>
          <div class="search-field d-none d-xl-block">
            <form class="d-flex align-items-center h-100" action="<?php echo $site_url?>search" method="get">
              <div class="input-group">
                <div class="input-group-prepend bg-transparent">
                  <i class="input-group-text border-0 mdi mdi-magnify"></i>
                </div>
                <input type="text" name="q" class="form-control bg-transparent border-0" placeholder="<?php echo elgg_echo('connect:search'); ?>">
                <input type="hidden" name="search_type" value="all">
              </div>
            </form>
          </div>
          <ul class="navbar-nav navbar-nav-right">
           
             <?php if (elgg_is_logged_in())
                    {
             ?>
            <li class="nav-item nav-language dropdown d-none d-md-block">
              <a class="nav-link dropdown-toggle" id="languageDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
                <div class="nav-language-icon">
                  <i class="mdi mdi-account-card-details" title="profile" id="profile"></i>
                </div>
                <div class="nav-language-text">
                  <p class="mb-1 text-black"><?php echo elgg_echo('connect:profile'); ?></p>
                </div>
              </a>
                
              <div class="dropdown-menu navbar-dropdown" aria-labelledby="languageDropdown">
                 
                   <div class="p-3 text-center bg-primary">
                  <img class="img-avatar img-avatar48 img-avatar-thumb" src="<?php echo $user->getIconURL('small');?>" alt="">
                  <p class="mb-1 text-white"><?php echo $user->name?></p>
                  <p class="mb-1 text-white"><?php echo $user->email?></p>
                </div>
                 <a class="dropdown-item" href="<?php echo $site_url ?>profile/<?php echo $user->username;?>/">
                  <div class="nav-language-icon mr-2">
                    <i class="mdi mdi-account-box-outline" title="view-profile" id="view"></i>
                  </div>
                  <div class="nav-language-text">
                    <p class="mb-1 text-black"><?php echo elgg_echo('connect:view_profile'); ?></p>
                  </div>
                </a>
                  <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="<?php echo $site_url ?>profile/<?php echo $user->username;?>/edit/">
                  <div class="nav-language-icon mr-2">
                    <i class="mdi mdi-auto-fix" title="edit-profile" id="edit"></i>
                  </div>
                  <div class="nav-language-text">
                    <p class="mb-1 text-black"><?php echo elgg_echo('connect:edit_profile'); ?></p>
                  </div>
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="<?php echo $site_url ?>avatar/edit/<?php echo $user->username;?>/">
                  <div class="nav-language-icon mr-2">
                    <i class="mdi mdi-camera" title="edit-avatar" id="avatar"></i>
                  </div>
                  <div class="nav-language-text">
                    <p class="mb-1 text-black"><?php echo elgg_echo('connect:edit_avatar'); ?></p>
                  </div>
                </a>
              </div>
            </li>
            
             <?php 
                    }
             ?>
            <li class="nav-item nav-profile dropdown">
              <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
                
                <div class="nav-profile-text">
                  <p class="mb-1 text-black"><?php echo elgg_echo('connect:main_menu'); ?></p>
                </div>
              </a>
              <div class="dropdown-menu navbar-dropdown dropdown-menu-right p-0 border-0 font-size-sm" aria-labelledby="profileDropdown" data-x-placement="bottom-end">
                 
                <div class="p-2">
                  
                  <?php echo elgg_view_menu('site', array('main_menu'=> 1)); ?>
                  
                  
                  
                </div>
              </div>
            </li>
            
            <li class="nav-item nav-profile dropdown">
              <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
                
                <div class="nav-profile-text">
                  <p class="mb-1 text-black"><?php echo elgg_echo('connect:more_menu'); ?></p>
                </div>
              </a>
              <div class="dropdown-menu navbar-dropdown dropdown-menu-right p-0 border-0 font-size-sm" aria-labelledby="profileDropdown" data-x-placement="bottom-end">
               
                <div class="p-2">
                  
                  <?php echo elgg_view_menu('site', array('main_menu'=> 2)); ?>
                  
                  
                </div>
              </div>
            </li>
            
             <?php 
                if (elgg_is_logged_in())
                    {
             ?>
            <li class="nav-item dropdown">
              <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-toggle="dropdown">
                <i class="mdi mdi-settings"></i>
                <span class="count-symbol bg-danger"></span>
              </a>
              <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
                
                <div class="dropdown-divider"></div>
                <a class="dropdown-item preview-item" href="<?php echo $site_url ?>settings/user/<?php echo $user->username;?>/">
                  <div class="preview-thumbnail">
                    <div class="preview-icon bg-success">
                      <i class="mdi mdi-wrench"></i>
                    </div>
                  </div>
                  <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                    
                    <p class="text-gray ellipsis mb-0"> <?php echo elgg_echo('connect:settings'); ?> </p>
                  </div>
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item preview-item" href="<?php echo $site_url ?>settings/statistics/<?php echo $user->username;?>/">
                  <div class="preview-thumbnail">
                    <div class="preview-icon bg-warning">
                      <i class="mdi mdi-chart-bar"></i>
                    </div>
                  </div>
                  <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                    
                    <p class="text-gray ellipsis mb-0"><?php echo elgg_echo('connect:statistics'); ?></p>
                  </div>
                </a>
                <?php


if (elgg_is_admin_logged_in())
{   
    ?>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item preview-item" href="<?php echo $site_url ?>admin/">
                  <div class="preview-thumbnail">
                    <div class="preview-icon bg-info">
                      <i class="mdi mdi-view-dashboard"></i>
                    </div>
                  </div>
                  <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                    
                    <p class="text-gray ellipsis mb-0"> <?php echo elgg_echo('connect:administration'); ?></p>
                  </div>
                </a>
                <?php
}
?>
                
              </div>
            </li>
            
            <li class="nav-item dropdown">
              <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="<?php echo $site_url ?>action/logout/">
                <i class="mdi mdi-logout ml-1"></i>
                <span class="count-symbol bg-danger"></span>
              </a>
              
            </li>
            <?php }
                                             ?>
            
             <?php
                echo elgg_view('page/core/account/login_dropdown');
             ?>
          </ul>
          
        </div>
      </nav>