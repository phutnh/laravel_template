<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class SendContractApproved extends Notification
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
      ->subject('Hợp đồng đã được duyệt')
      ->line('Hợp đồng bạn gửi đã được duyệt')
      ->action('Chi tiết', route('admin.hopdong.update', $this->hopdong_id))
      ->line('Vui lòng vào trang quản lý để duyệt hợp đồng này.');
  }

  public function toArray($notifiable)
  {
    return [
    ];
  }
}
