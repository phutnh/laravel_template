<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class SendContractApprove extends Notification
{
  use Queueable;

  protected $hopdong_id;

  public function __construct($hopdong_id)
  {
     $this->hopdong_id = $hopdong_id; 
  }

  public function via($notifiable)
  {
      return ['mail'];
  }

  public function toMail($notifiable)
  {
    return (new MailMessage)->greeting('Xin chào bạn!')
      ->subject('Hợp đồng yêu cầu duyệt')
      ->line('Một tài khoản đã gửi yêu cầu duyệt hợp đồng')
      ->action('Truy cập', route('admin.hopdong.update', $this->hopdong_id))
      ->line('Vui lòng vào trang quản lý để duyệt hợp đồng này.');
  }

  public function toArray($notifiable)
  {
    return [
    ];
  }
}
