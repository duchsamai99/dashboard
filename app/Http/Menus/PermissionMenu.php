<?php
namespace App\Http\Menus;
use App\Models\AdminMenuRole;
class PermissionMenu{
  // public function permissionView($menuID, $menuName){
  //   $user = auth()->user();
  //   $current_user_id = $user['id'];
  //   $menu_role = $user['menuroles'];
  //   if($user->type != 1){
  //     $result = [
  //       'status'=> true
  //     ];
  //     return $result;
  //   }else{

  //   }
  // }
  public function permission($menuID, $menuName, $permission_action){
    $msg_start_fail = 'You have no permission for ';
    $msg_end_fail = ' this page, please contact administrator!';
    $msg_success_start = 'You have ';
    $msg_success_end = ' successfully.';
    $user = auth()->user();
    $current_user_id = $user['id'];
    $menu_role = $user['menuroles'];
    if($user->type == 1){
      $result = [
        'status'=> true,
        'message' => $msg_success_start.$permission_action.$msg_success_end
      ];
      return $result;
    }else{
      $role_permission = AdminMenuRole::where('amrRoleName', $menu_role )->where( 'amrMenusID', $menuID )->first();
      if(!empty($role_permission)){
        if($permission_action == 'insert'){
          if($role_permission->amrInsert == 1){
            $result = array(
              'status'=> true,
              'message' => $msg_success_start.$permission_action.'ed'.$msg_success_end
            );
            return $result;
          }else{
            $result = array(
              'status'=> false,
              'message' => $msg_start_fail.$permission_action.$msg_end_fail
            );
            return $result;
          }
        }
        if($permission_action == 'update'){
          if($role_permission->amrUpdate == 1){
            $result = array(
              'status'=> true,
              'message' => $msg_success_start.$permission_action.'d'.$msg_success_end
            );
            return $result;
          }else{
            $result = array(
              'status'=> false,
              'message' => $msg_start_fail.$permission_action.$msg_end_fail
            );
            return $result;
          }
        }
        if($permission_action == 'delete'){
          if($role_permission->amrDelete == 1){
            $result = array(
              'status'=> true,
              'message' => $msg_success_start.$permission_action.'d'.$msg_success_end
            );
            return $result;
          }else{ 
            $result = array(
              'status'=> false,
              'message' => $msg_start_fail.$permission_action.$msg_end_fail
            );
            return $result;
          }
        }
      }else{
        $result = array(
          'status'=> false,
          'message' => $msg_start_fail.$permission_action.$msg_end_fail
        );
        return $result;
      }  
    }  
  }   
}
