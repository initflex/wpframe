<?php

namespace WPFP\App\Libraries;

class Email
{
	public function send_email($dataMail = NULL)
	{

		// check send email data
		if ($dataMail !== NULL && is_array($dataMail)) {

			// check var for check set data mail
			$this->mailto = isset($dataMail['to']) && trim($dataMail['to']) !== '' ?
				trim($dataMail['to']) : FALSE;

			$this->mailsub = isset($dataMail['subject']) && trim($dataMail['subject']) !== '' ?
				trim($dataMail['subject']) : FALSE;

			$this->mailmsg = isset($dataMail['messege']) && trim($dataMail['messege']) !== '' ?
				trim($dataMail['messege']) : FALSE;

			$this->mailfrom = isset($dataMail['from']) && trim($dataMail['from']) !== '' ?
				trim($dataMail['from']) : FALSE;

			$this->mailfromName = isset($dataMail['from_name']) && trim($dataMail['from_name']) !== '' ?
				trim($dataMail['from_name']) : FALSE;

			$this->mailfile = isset($dataMail['file']) && trim($dataMail['file']) !== '' ?
				trim($dataMail['file']) : NULL;

			$this->mailcc = isset($dataMail['cc']) && trim($dataMail['cc']) !== '' ?
				trim($dataMail['cc']) : FALSE;

			$this->mailbcc = isset($dataMail['bcc']) && trim($dataMail['bcc']) !== '' ?
				trim($dataMail['bcc']) : FALSE;

			// check set data mail to, subject, messege, and from 
			if ($this->mailto && $this->mailsub && $this->mailmsg && $this->mailfrom) {

				// refrence code from 
				// codexworld.com/send-email-with-attachment-php/

				//recipient 
				$to = $this->mailto;
				//sender 
				$from = $this->mailfrom;
				$fromName = $this->mailfromName;
				//email subject 
				$subject = $this->mailsub;

				//attachment file path 
				$file = "index.php";
				//email body content 
				$htmlContent = $this->mailmsg;
				//header for sender info 
				$headers = "From: $fromName" . " <" . $from . ">";
				//boundary  
				$semi_rand = md5(time());
				$mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";

				//headers for attachment  
				$headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\"";

				// check set cc and bcc 
				if ($this->mailcc) {
					// Cc email 
					$headers  .=  "\nCc: $this->mailcc";
				}

				if ($this->mailbcc) {
					// Bcc email 
					$headers  .=  "\nBcc: $this->mailbcc";
				}

				//multipart boundary  
				$message = "--{$mime_boundary}\n" . "Content-Type: text/html; charset=\"UTF-8\"\n" . "Content-Transfer-Encoding: 7bit\n\n" . $htmlContent . "\n\n";
				//preparing attachment 
				if (!empty($file) > 0) {
					if (is_file($file)) {
						$message .= "--{$mime_boundary}\n";
						$fp =    @fopen($file, "rb");
						$data =  @fread($fp, filesize($file));
						@fclose($fp);
						$data = chunk_split(base64_encode($data));
						$message .= "Content-Type: application/octet-stream; name=\"" . basename($file) . "\"\n" . "Content-Description: " . basename($file) . "\n" .         "Content-Disposition: attachment;\n" . " filename=\"" . basename($file) . "\"; size=" . filesize($file) . ";\n" . "Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";
					}
				}

				$message .= "--{$mime_boundary}--";
				$returnpath = "-f" . $from;
				//send email 
				$mail = @mail($to, $subject, $message, $headers, $returnpath);
				//email sending status 
				return $mail ? TRUE : FALSE;
			} else {
				return FALSE;
			}
		} else {
			return FALSE;
		}
	}
}
