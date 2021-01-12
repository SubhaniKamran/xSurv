<?php
namespace App\Http\Controllers;

use App\Models\NotificationSetting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class NotificationSettingController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth');
  }

  // Company Notification Setting - Start
  public function DisplayCompanyNotificationSetting()
  {
    $user_id = Auth::id();
    $notification_setting = DB::table('notification_settings')
                ->where('user_id', '=', $user_id)
                ->get();

    return view('company.setting.notification', compact('notification_setting'));
  }

  public function EnableCompanyNotificationSetting($id)
  {
    DB::beginTransaction();
    $affected = DB::table('notification_settings')
                  ->where('id', $id)
                  ->update([
                    'status' => 1,
                    'updated_at' => Carbon::now()
                  ]);
    if($affected){
      DB::commit();
      echo "Success";
      return redirect(url('/company/notification/setting'))->with('message','Notification Status Updated Successfully');
    }
    else {
      DB::rollback();
      return redirect(url('/company/notification/setting'))->with('error','Error! An Unhandled Exception Occured');
    }
  }

  public function DisableCompanyNotificationSetting($id)
  {
    DB::beginTransaction();
    $affected = DB::table('notification_settings')
                  ->where('id', $id)
                  ->update([
                    'status' => 0,
                    'updated_at' => Carbon::now()
                  ]);
    if($affected){
      DB::commit();
      return redirect(url('/company/notification/setting'))->with('message','Notification Status Updated Successfully');
    }
    else {
      DB::rollback();
      return redirect(url('/company/notification/setting'))->with('error','Error! An Unhandled Exception Occured');
    }
  }

  public function UnreadCompanyNotifications(Request $request)
  {
    $user_id = Auth::id();
    $TotalNotifications = 0;
    $ListItems = '';
    $company_notifications = DB::table('notifications')
                  ->join('profiles', 'profiles.user_id', '=', 'notifications.sender_id')
                  ->where('reciever_id', $user_id)
                  ->where('status', 'unread')
                  ->select('notifications.*', 'profiles.image AS profileImage')
                  ->orderBy('created_at', 'desc')
                  ->limit(4)
                  ->get();

    $TotalNotifications = sizeof($company_notifications);

    foreach($company_notifications as $notification)
    {
      $current_date = Carbon::now();
      $created_date = $notification->created_at;
      $created_date = Carbon::parse($created_date);
      $diff = $created_date->diffForHumans($current_date);
      $profile_image = asset('public/storage/profile/' . $notification->profileImage);
      $notification_page = url('company/all/notifications');
      if (!Storage::disk('profile')->exists($notification->profileImage)) {
        $profile_image = asset('public/storage/profile/dummy.jpg');
      }
      $ListItems .=
      '<a href="'. $notification_page .'" class="dropdown-item py-3">
          <small class="float-right text-muted pl-2 topSetting">'. $diff .'</small>
          <div class="media">
              <img src="'. $profile_image.'" style="height:36px; width: 36px;border-radius: 50%;">
              <div class="media-body align-self-center ml-2 text-truncate">
                  <h6 class="my-0 font-weight-normal text-dark">'. substr($notification->message, 0, 21) .'</h6>
              </div>
          </div>
      </a>';
    }

    $Data['Total'] = $TotalNotifications;
    $Data['Items'] = $ListItems;
    return json_encode($Data);
  }

  public function AllCompanyNotifications()
  {
    $user_id = Auth::id();
    // Change the status of all company notifications to read
    DB::table('notifications')
            ->where('reciever_id', $user_id)
            ->update([
              'status' => 'read',
              'updated_at' => Carbon::now()
            ]);

    $company_notifications = DB::table('notifications')
                  ->join('profiles', 'profiles.user_id', '=', 'notifications.sender_id')
                  ->where('reciever_id', $user_id)
                  ->select('notifications.*', 'profiles.image AS profileImage')
                  ->orderBy('created_at', 'desc')
                  ->limit(10)
                  ->get();

    return view('company.notification.index', compact('company_notifications'));
  }
  // Company Notification Setting - End

  // Admin Notification Setting - Start
  public function DisplayAdminNotificationSetting()
  {
    $user_id = Auth::id();
    $notification_setting = DB::table('notification_settings')
                ->where('user_id', '=', $user_id)
                ->get();

    return view('admin.setting.notification', compact('notification_setting'));
  }

  public function EnableAdminNotificationSetting($id)
  {
    DB::beginTransaction();
    $affected = DB::table('notification_settings')
                  ->where('id', $id)
                  ->update([
                    'status' => 1,
                    'updated_at' => Carbon::now()
                  ]);
    if($affected){
      DB::commit();
      echo "Success";
      return redirect(url('/admin/notification/setting'))->with('message','Notification Status Updated Successfully');
    }
    else {
      DB::rollback();
      return redirect(url('/admin/notification/setting'))->with('error','Error! An Unhandled Exception Occured');
    }
  }

  public function DisableAdminNotificationSetting($id)
  {
    DB::beginTransaction();
    $affected = DB::table('notification_settings')
                  ->where('id', $id)
                  ->update([
                    'status' => 0,
                    'updated_at' => Carbon::now()
                  ]);
    if($affected){
      DB::commit();
      return redirect(url('/admin/notification/setting'))->with('message','Notification Status Updated Successfully');
    }
    else {
      DB::rollback();
      return redirect(url('/admin/notification/setting'))->with('error','Error! An Unhandled Exception Occured');
    }
  }

  public function UnreadAdminNotifications(Request $request)
  {
    $TotalNotifications = 0;
    $ListItems = '';
    $admin_notifications = DB::table('notifications')
                  ->join('profiles', 'profiles.user_id', '=', 'notifications.sender_id')
                  ->where('reciever_id', 1)
                  ->where('status', 'unread')
                  ->select('notifications.*', 'profiles.image AS profileImage')
                  ->orderBy('created_at', 'desc')
                  ->limit(4)
                  ->get();

    $TotalNotifications = sizeof($admin_notifications);

    foreach($admin_notifications as $notification)
    {
      $current_date = Carbon::now();
      $created_date = $notification->created_at;
      $created_date = Carbon::parse($created_date);
      $diff = $created_date->diffForHumans($current_date);
      $profile_image = asset('public/storage/profile/' . $notification->profileImage);
      $notification_page = url('admin/all/notifications');
      if (!Storage::disk('profile')->exists($notification->profileImage)) {
        $profile_image = asset('public/storage/profile/dummy.jpg');
      }
      $ListItems .=
      '<a href="' . $notification_page . '" class="dropdown-item py-3">
          <small class="float-right text-muted pl-2 topSetting">'. $diff .'</small>
          <div class="media">
              <img src="'. $profile_image.'" style="height:36px; width: 36px;border-radius: 50%;">
              <div class="media-body align-self-center ml-2 text-truncate">
                  <h6 class="my-0 font-weight-normal text-dark">'. substr($notification->message, 0, 21) .'</h6>
              </div>
          </div>
      </a>';
    }

    $Data['Total'] = $TotalNotifications;
    $Data['Items'] = $ListItems;
    return json_encode($Data);
  }

  public function AllAdminNotifications()
  {
    // Change the status of all company notifications to read
    DB::table('notifications')
            ->where('reciever_id', 1)
            ->update([
              'status' => 'read',
              'updated_at' => Carbon::now()
            ]);

    $admin_notifications = DB::table('notifications')
                  ->join('profiles', 'profiles.user_id', '=', 'notifications.sender_id')
                  ->where('reciever_id', 1)
                  ->select('notifications.*', 'profiles.image AS profileImage')
                  ->orderBy('created_at', 'desc')
                  ->limit(10)
                  ->get();

    return view('admin.notification.index', compact('admin_notifications'));
  }
  // Admin Notification Setting - End
}
