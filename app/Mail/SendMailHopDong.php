<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendMailHopDong extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $user;
    public $gia_thue;
    public $don_gia_dien;
    public $don_gia_nuoc;
    public $phi_dich_vu;
    public $tien_xe_may;
    public $ngay_tao;
    public $ngay_ket_thuc;

    public function __construct($user, $gia_thue, $don_gia_dien, $don_gia_nuoc, $phi_dich_vu, $tien_xe_may, $ngay_tao, $ngay_ket_thuc)
    {
        $this->user = $user;
        $this->gia_thue = $gia_thue;
        $this->don_gia_dien = $don_gia_dien;
        $this->don_gia_nuoc = $don_gia_nuoc;
        $this->phi_dich_vu = $phi_dich_vu;
        $this->tien_xe_may = $tien_xe_may;
        $this->ngay_tao = $ngay_tao;
        $this->ngay_ket_thuc = $ngay_ket_thuc;
    }
    public function build()
    {
        return $this->subject('Thông báo tạo hợp đồng thành công!')->html($this->generateEmailContent());
    }
    private function generateEmailContent()
    {
        return "
    <head>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .header {
            font-size: 20px;
            font-weight: bold;
            color: #333;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .table th, .table td {
            text-align: left;
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }
        .table th {
            background-color: #f2f2f2;
        }
        .footer {
            margin-top: 20px;
            font-size: 14px;
            color: #555;
        }
        .link {
            color: #007bff;
            text-decoration: none;
        }
        .link:hover {
            text-decoration: underline;
        }
    </style>
    </head>
    <body>
    <div class='container'>
        <p>Xin chào, <strong>{$this->user->name}</strong>,</p>

        <p>Chúc mừng bạn đã tạo hợp đồng thành công!</p>

        <table class='table'>
            <tr>
                <th>Mục</th>
                <th>Chi tiết</th>
            </tr>
            <tr>
                <td>Giá thuê</td>
                <td>{$this->gia_thue}</td>
            </tr>
            <tr>
                <td>Tiền điện</td>
                <td>{$this->don_gia_dien} vnđ/kWh</td>
            </tr>
            <tr>
                <td>Tiền nước</td>
                <td>{$this->don_gia_nuoc} vnđ/m3</td>
            </tr>
            <tr>
                <td>Tiền gửi xe máy</td>
                <td>{$this->tien_xe_may}vnđ số lượng xe/tháng</td>
            </tr>
            <tr>
                <td>Tiền dịch vụ phòng</td>
                <td>{$this->phi_dich_vu} người/tháng</td>
            </tr>
            <tr>
                <td>Ngày tạo</td>
                <td>{$this->ngay_tao}</td>
            </tr>
            <tr>
                <td>Ngày kết thúc</td>
                <td>{$this->ngay_ket_thuc}</td>
            </tr>
        </table>
        <p>Quý khách có thể truy cập
            <a href='https://sghouses.vercel.app/profile/history'class='link'>tại đây</a>
            để xem hợp đồng và thanh toán online!
        </p>

        <p class='footer'>Xin cảm ơn,<br>BQL Sghouses.</p>
    </div>
    </body>
        ";
    }
    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Thông báo tạo hợp đồng thuê nhà thành công!',
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
