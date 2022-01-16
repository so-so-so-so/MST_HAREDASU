<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TestSendMail extends Mailable
{
  use Queueable, SerializesModels;

  /**
   * Create a new message instance.
   *
   * @return void
   */
  public function __construct($email)
  {
    //
    $this->email = $email;
  }

  /**
   * Build the message.
   *
   * @return $this
   */
  public function build()
  {
    return $this
      //メールの件名
      ->subject('[新規登録]ハレダスのユーザ登録画面へのご案内')
      //メールとして表示したいビューファイル
      ->view('test.mail')
      ->with(['email' => $this->email]);
  }
}
