<?php
namespace app\common\api;
use app\common\api\Base;
use think\Env;

/**
 * 邮件内部接口
 */
class Email extends Base
{   

        public $option = [
            'smtp_host' => 'smtp.qq.com',
            'smtp_port' => 465,
            'smtp_user' => '308715744@qq.com',
            'smtp_pass' => 'sghqrxpsdnkubgjf',
            'from_email' => 'neconano@qq.com',
            'from_name' => 'neconano@qq.com',
        ];
        
        public function send_mail_debug(){
            $to = '308715744@qq.com';
            $name = 'Neco';
            $title = '跟投喵交单提醒';
            $body = 'This is the HTML message body <b>in bold!</b>';
            $res = $this->send_mail($to, $name, $title, $body);
            dump($res);
        }

        /**
        * 系统邮件发送函数
        * @param string $to    接收邮件者邮箱
        * @param string $name  接收邮件者名称
        * @param string $subject 邮件主题
        * @param string $body    邮件内容
        * @param string $attachment 附件列表
        * @return boolean
        */
        public function send_mail($to, $name, $subject = '', $body = '', $attachment = null){
            $mail = new \PHPMailer();
            $mail->CharSet    = 'UTF-8'; //设定邮件编码，默认ISO-8859-1，如果发中文此项必须设置，否则乱码
            $mail->IsSMTP();  // 设定使用SMTP服务
            $mail->SMTPDebug  = 0;                     // 关闭SMTP调试功能
            // $mail->SMTPDebug  = 2;                     // 关闭SMTP调试功能
            // 1 = errors and messages
            // 2 = messages only
            $mail->SMTPAuth   = true;                  // 启用 SMTP 验证功能
            $mail->SMTPSecure = 'ssl';                 // 使用安全协议
            $mail->Host       = Env::get("smtp_host")?:$this->option['smtp_host'];  // SMTP 服务器
            $mail->Port       = Env::get("smtp_port")?:$this->option['smtp_port'];  // SMTP服务器的端口号
            $mail->Username   = Env::get("smtp_user")?:$this->option['smtp_user'];  // SMTP服务器用户名
            $mail->Password   = Env::get("smtp_pass")?:$this->option['smtp_pass'];  // SMTP服务器密码
            $mail->SetFrom(Env::get("from_email")?:$this->option['from_email'], Env::get("from_name")?:$this->option['from_name']);
            $replyEmail       = Env::get("from_email")?:$this->option['from_email'];
            $replyName        = Env::get("from_name")?:$this->option['from_name'];
            $mail->AddReplyTo($replyEmail, $replyName);
            $mail->Subject    = $subject;
            $mail->AltBody    = "为了查看该邮件，请切换到支持 HTML 的邮件客户端";
            $mail->MsgHTML($body);
            $mail->AddAddress($to, $name);
            if(is_array($attachment)){ // 添加附件
                foreach ($attachment as $file){
                    is_file($file) && $mail->AddAttachment($file);
                }
            }
            return  $mail->Send() ? true : $mail->ErrorInfo;
        }

}
