<?php
class RM_Email
{
    /**
    * Character set (default: utf-8)
    *
    * @var	string
    */
    public $charset		= 'UTF-8';
    
    /**
    * Message headers
    *
    * @var	string[]
    */
    protected $headers		= array();
    
    /**
    * Message format.
    *
    * @var	string	'text' or 'html'
    */
    public $content_type	= 'html';
    
    /**
    * Final headers to send
    *
    * @var	string
    */
    protected $header_str		= '';
    
    /**
    * Newline character sequence.
    */
    public $newline		= "\r\n";	
    
    /**
    * Subject header
    *
    * @var	string
    */
    protected $subject		= '';
   /**
    * Message body
    *
    * @var	string
    */
    protected $body		= '';
    
    /**
    * Attachment data
    *
    * @var	array
    */
    protected $attachments		= array();
    
    protected $to= array();
        
    /**
    * The constructor can be passed an array of config values
    *
    * @param	array	$config = array()
    * @return	void
    */
    public function __construct($config = array())
    {
        $this->initialize($config);
    }
    
    /**
	 * Initialize preferences
	 *
	 * @param	array	$config
	 * @return	RM_Email
    */
    public function initialize(array $config = array())
    {
            $this->clear();
            foreach ($config as $key => $val)
            {
                    if (isset($this->$key))
                    {
                            $method = 'set_'.$key;
                            if (method_exists($this, $method))
                            {
                                    $this->$method($val);
                            }
                            else
                            {
                                    $this->$key = $val;
                            }
                    }
            }
            $this->charset = strtoupper($this->charset);
            return $this;
    }
    
    /**
    * Initialize the Email Data
    *
    * @param	bool
    * @return	void
    */
    public function clear($clear_attachments = FALSE)
    {
            $this->subject		= '';
            $this->body		= '';
            $this->headers		= array();
            $this->header_str	= '';
            $this->_attachments = array();
    }
    
    /**
    * Set FROM
    *
    * @param	string	$from
    * @param	string	$name
    * @return	void
    */
   public function from($from, $name = '')
   {
        if (preg_match('/\<(.*)\>/', $from, $match))
        {
                $from = $match[1];
        }
        $this->set_header('From', $name.' <'.$from.'>');
   }
   
   /**
    * Add a Header Item
    *
    * @param	string
    * @param	string
    * @return	void
    */
   public function set_header($header, $value)
   {
           $this->headers[$header] = str_replace(array("\n", "\r"), '', $value);
   }
   
   /**
    * Set Content Type
    *
    * @param	string
    */
   public function set_content_type($type = 'text')
   {
           $this->content_type = ($type === 'html') ? 'html' : 'text';
   }
   
   /**
    * Build final headers
    *
    * @return	void
    */
   protected function build_headers()
   {
           $this->set_header('X-Sender', $this->headers['From']);
   }
   
   /**
    * Build final body
    *
    * @return	void
    */
   protected function set_body($body)
   {
           $this->body= $body;
   }
   
   /**
    * Write Headers as a string
    *
    * @return	void
    */
   protected function write_headers()
   {
           $this->header_str = '';
           foreach ($this->headers as $key => $val)
           {
                   $val = trim($val);
                   if ($val !== '')
                   {
                           $this->header_str .= $key.': '.$val.$this->newline;
                   }
           }
           
           if($this->content_type=="plain")
               $this->header_str .= 'Content-Type: text/plain; charset='.$this->charset.$this->newline;
           
           if($this->content_type=="html")
               $this->header_str .= 'Content-Type: text/html; charset='.$this->charset.$this->newline;
           
           $this->header_str = rtrim($this->header_str);
   }
   
   /**
    * Set Reply-to
    *
    * @param	string
    * @param	string
    */
   public function reply_to($replyto, $name = '')
   {
           if (preg_match('/\<(.*)\>/', $replyto, $match))
           {
                   $replyto = $match[1];
           }
           $this->set_header('Reply-To', $name.' <'.$replyto.'>');
   }
        
   /**
    * Send Email
    *
    * @param	bool	$auto_clear = TRUE
    * @return	bool
    */
   public function send($auto_clear = TRUE)
   {
       add_action('phpmailer_init', array($this,'config_phpmailer'));
       $this->build_headers();
       
       if (empty($this->to))
            return false;
      
        return wp_mail($this->to, $this->subject, $this->body, $this->header_str, $this->attachments);
   }
   
   /**
    * Set Recipients
    *
    * @param	string
    */
   public function to($to)
   {
       $this->set_header('To', $to);
       $this->to= $to;
   }
   
   /**
    * Set Body
    *
    * @param	string
    */
   public function message($body)
   {
           $this->body = rtrim(str_replace("\r", '', $body));
   }
   
   /**
    * Set Email Subject
    *
    * @param	string
    */
   public function subject($subject)
   {
        $this->subject= $subject;
        $this->set_header('Subject', $subject);
   }
   
   /**
    * Assign file attachments
    *
    * @param	string	$file	Can be local path, URL or buffered content
    * @param	string	$disposition = 'attachment'
    * @param	string	$newname = NULL
    * @param	string	$mime = ''
    */
   public function attach($files)
   {
       $this->attachments= $files;
   }
   
   public function config_phpmailer($phpmailer) 
   {
       $options = new RM_Options;
       if ($options->get_value_of('enable_smtp') == 'yes') {
            $phpmailer->isSMTP();
            $phpmailer->SMTPDebug = 0;
            $phpmailer->Host = $options->get_value_of('smtp_host');
            $phpmailer->SMTPAuth = $options->get_value_of('smtp_auth') == 'yes' ? true : false;
            $phpmailer->Port = $options->get_value_of('smtp_port');
            $phpmailer->Username = $options->get_value_of('smtp_user_name');
            $phpmailer->Password = $options->get_value_of('smtp_password');
            $phpmailer->SMTPSecure = ($options->get_value_of('smtp_encryption_type') == 'enc_tls') ? 'tls' : (($options->get_value_of('smtp_encryption_type') == 'enc_ssl') ? 'ssl' : '' );
        }
        $phpmailer->From = $options->get_value_of('senders_email');
        $phpmailer->FromName = $options->get_value_of('senders_display_name');
        if(empty($phpmailer->AltBody))
            $phpmailer->AltBody = RM_Utilities::html_to_text_email($phpmailer->Body);
        return;
    }
    
    public function get_to()
    {
        return $this->to;
    }
    
     
    public function get_subject()
    {
        return $this->subject;
    }
    
    public function get_message()
    {
        return $this->body;
    }
    
    public function get_header()
    {
        return $this->header_str;
    }
        
}