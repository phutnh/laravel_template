<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class SendContractApprove extends Notification
{
  use Queueable;

  protected $hopdong;

  public function __construct($hopdong)
  {
     $this->hopdong = $hopdong; 
  }

  public function via($notifiable)
  {
      return ['mail'];
  }

  public function toMail($notifiable)
  {
    return (new MailMessage)->greeting('Xin chào bạn!')
      ->subject('Hợp đồng yêu cầu duyệt')
      ->line($this->hopdong->nhanvien->tennhanvien . ' đã gửi yêu cầu duyệt hợp đồng')
      ->action('Truy cập', route('admin.hopdong.update', $this->hopdong->id))
      ->line('Vui lòng vào trang quản lý để duyệt hợp đồng này.');
  }

  public function toArray($notifiable)
  {
    return [
    ];
  }
}
