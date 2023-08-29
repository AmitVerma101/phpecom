<?php 
    class CustomException extends Exception{
       protected $message;
       protected $line;

       public function __construct($message){
            $this->message = $message;
            $line = __line__;
            $messageWithLineNumber = "$this->message Line $this->line";
            parent::__construct($messageWithLineNumber);
            #clearing the pipeline
            ob_end_clean();
       }

    }


?>