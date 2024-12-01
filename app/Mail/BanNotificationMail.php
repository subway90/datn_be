<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BanNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $user;
    public $noiDungCam;

    public function __construct($user, $noiDungCam)
    {
        $this->user = $user;
        $this->noiDungCam = $noiDungCam;
    }

    public function build()
    {
        // Gửi email với nội dung là text hoặc HTML
        return $this->subject('Thông báo tài khoản bị cấm')
            ->html($this->generateEmailContent());  // Gửi nội dung email ở dạng HTML
    }

    /**
     * Tạo nội dung email dưới dạng HTML.
     */
    private function generateEmailContent()
    {
        // Tạo nội dung HTML của email
        return "
        <html>
        <head>
            <title>Thông báo tài khoản bị cấm</title>
        </head>
        <body>
            <h1>Xin chào {$this->user->name},</h1>
            <p>Tài khoản của bạn đã bị cấm vì lý do sau:</p>
            <p><strong>{$this->noiDungCam}</strong></p>
            <p>Vui lòng liên hệ bộ phận hỗ trợ nếu bạn có thắc mắc.</p>
            <p>Trân trọng,<br>Đội ngũ quản trị</p>
        </body>
        </html>
        ";
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Ban Notification Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'view.name',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
