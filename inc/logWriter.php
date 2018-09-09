<?php 
namespace Api\inc;

/**
* @author  j.herzig
* @since   09.09.2018
* @link    Original https://github.com/dlenhart/st-php-logger
* @version 1.0.1
*/

class logWriter
   { 
        /**
        * $log_file - path and log file name
        * @var string
        */
        protected $log_file;
        /**
        * $file - file
        * @var string
        */
        protected $file;
        /**
        * $options - settable options - future use - passed through constructor
        * @var array
        */
        protected $options = array(
            'dateFormat' => 'd-M-Y H:i:s'
        );
        /**
        * Class constructor
        * @param string $log_file - path and filename of log
        * @param array $params
        */
        public function __construct($log_folder = 'error.txt', $params = array()){
            $time = date('d-M-Y');
            $this->log_file = "{$log_folder}/log_{$time}.txt";
            $this->params = array_merge($this->options, $params);
            $this->folderExist($log_folder);

            //Create log file if it doesn't exist.
            if(!file_exists($this->log_file)){               
                fopen($this->log_file, 'w') or exit("Can't create $this->log_file!");
            }
            //Check permissions of file.
            if(!is_writable($this->log_file)){   
                //throw exception if not writable
                throw new Exception("ERROR: Unable to write to file!", 1);
            }
        }

        /**
        * Erstellt einen Ordner falls nicht vorhanden
        * @param string $log_file
        */
        private function folderExist($directoryPath){
            if (!file_exists($directoryPath)) {
                mkdir($directoryPath);
            }
        }

        /**
        * Info method (write info message)
        * @param string $message
        * @return void
        */
        public function info($message){
            $this->writeLog($message, 'INFO');
        }
        /**
        * Debug method (write debug message)
        * @param string $message
        * @return void
        */
        public function debug($message){
            $this->writeLog($message, 'DEBUG');
        }
        /**
        * Warning method (write warning message)
        * @param string $message
        * @return void
        */
        public function warning($message){
            $this->writeLog($message, 'WARNING');
        }
        /**
        * Error method (write error message)
        * @param string $message
        * @return void
        */
        public function error($message){
            $this->writeLog($message, 'ERROR');
        }
        /**
        * Write to log file
        * @param string $message
        * @param string $severity
        * @return void
        */
        public function writeLog($message, $severity) {
            // open log file
            if (!is_resource($this->file)) {
                $this->openLog();
            }
            // grab the url path ( for troubleshooting )
            $path = $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
            //Grab time - based on timezone in php.ini
            $time = date($this->params['dateFormat']);
            // Write time, url, & message to end of file
            fwrite($this->file, "[$time] [$path] : [$severity] - $message" . PHP_EOL);
        }
        /**
        * Open log file
        * @return void
        */
        private function openLog(){
            $openFile = $this->log_file;
            // 'a' option = place pointer at end of file
            $this->file = fopen($openFile, 'a') or exit("Can't open $openFile!");
        }
        /**
         * Class destructor
         */
        public function __destruct(){
            if ($this->file) {
                fclose($this->file);
            }
        }

    } 
?>