<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPassword extends Notification
{
  use Queueable;

  protected $token;

  public function __construct($token_key)
  {
     $this->token = $token_key; 
  }

  public function via($notifiable)
  {
      return ['mail'];
  }

  public function toMail($notifiable)
  {
    return (new MailMessage)->greeting('Xin chào bạn!')
      ->subject('Khôi phục mật khẩu của bạn')
      ->line('Bạn vừa gửi một yêu cầu để thay dổi mật khẩu vui lòng click vào button bên dưới để thay đổi mật khẩu của bạn:')
      ->action('Khôi phục', route('password.reset', $this->token))
      ->line('Nếu không phải bạn gửi yêu cầu vui lòng bỏ qua thư này.');
  }

  public function toArray($notifiable)
  {
    return [
    ];
  }
}
