/*
 * Logger - a PHP logging class
 *
 * This is a logging class makes logging in PHP web apps easy
 *
 * Originally Developed in PHP version 7
 *
 * LICENSE: Creative Commons: Attribution-ShareAlike 4.0 International
 *
 * @author     Ben Yanke <ben@benyanke.com>
 * @copyright  Ben Yanke
 * @license    https://creativecommons.org/licenses/by-sa/4.0/ CC Attribution-ShareAlike 4.0 International
 * @link       https://github.com/benyanke/logger
 * @since      Version 0.1.0
 */

/*
LOGGING LEVELS:

DEBUG
Information that you never need to see if the system is working properly. These would only be used in development, Examples:
  "Received a message on topic X from caller Y"
  "Sent 20 bytes on socket 9".

INFO
Small amounts of information that may be useful to a user. Examples:
  "New user account created: u: $username, id: $user_id"
  "New job created: $jobname, id: $job_id"

WARN
Information that the user may find alarming, and may affect the output of the application, but is part of the expected working of the system. Examples:
  "Could not load configuration file from <path>. Using defaults."

ERROR
Something serious (but recoverable) has gone wrong. Examples:
  "$className could not be autoloaded."
  "Outgoing email failed. Recipient $email_to"

FATAL
Something unrecoverable has happened. Examples:
  "Database connection failed with error #545643."
*/

class Log {
    private $logEntries;
    private $currentLogLevel;
    private $defaulLogLevel = "WARN";
    private $defaultReporingLevel = "WARN";
    private $logLevels = array(0 => 'FATAL', 1 => 'ERROR', 2 => 'WARN', 3 => 'INFO', 4 =>'DEBUG');

    public function __construct() {
      $this->setLogLevel($this->defaulLogLevel);
    }

    /*
     *  Login Functions
     */

     private function isValidLogLevel($level) {
       if (in_array($level, $this->logLevels)) {
         return true;
       } else {
         return false;
       }

     }

     // Don't use this
     public function setLogLevel($level) {
         // Sanatize inputs
         $level = strtoupper($level);

         if($this->isValidLogLevel($level)) {
            $this->currentLogLevel = $level;
         } else {
           throw new Exception('Not a valid logging level');
         }
     }

     private function getLevelNumberByName($level) {
       // Sanatize inputs
       $level = strtoupper($level);

       if($this->isValidLogLevel($level)) {
          $this->currentLogLevel = $level;
       } else {
         throw new Exception('Not a valid logging level');
       }

        for($i = 0; $i < count($this->logLevels); $i++) {
          if($this->logLevels[$i] == $level) {
            return $i;
          }
        }

        throw new Exception('Level not found');

     }

     public function log($message, $level = null) {

       if ($level == null) {
         $level = $this->currentLogLevel;
       }

       // Sanitize inputs:
       $level = strtoupper($level);
       $message = trim($message);

       // validate inputs
       if(! $this->isValidLogLevel($level)) {
         throw new Exception('Not a valid logging level');
       }

       $logEntry = array('level' => $level, 'text' => $message, 'timestamp' => date('r'));

       $this->logEntries[] = $logEntry;
     }

     public function getLogContentArrayByLevel($level) {
        // = $this->currentLogLevel
      $out = array();
       for($i = 0; $i < count($this->logEntries); $i++) {
         if($this->getLevelNumberByName($level) >= $this->getLevelNumberByName($this->logEntries[$i]['level'])) {
           $out[] = $this->logEntries[$i];
         }
       }

       return $out;
     }

     public function getHtmlLogContent($level = null) {
       if ($level == null) {
         $level = $this->defaultReporingLevel;
       }

       $logRows = $this->getLogContentArrayByLevel($level);
        for($i = 0; $i < count($logRows); $i++) {
            echo "[" . $logRows[$i]['timestamp'] . "] [" . $logRows[$i]['level'] . "] " .  $logRows[$i]['text'] . "<br/>\n";
        }
      }

      public function logToBrowserConsole($level = null) {
        if ($level == null) {
          $level = $this->defaultReporingLevel;
        }

        echo "\n<script>\n";
        $logRows = $this->getLogContentArrayByLevel($level);
         for($i = 0; $i < count($logRows); $i++) {
             echo "     console.log(\"[" . $logRows[$i]['timestamp'] . "] [" . $logRows[$i]['level'] . "] " .  $logRows[$i]['text'] . "\");\n";
         }
         echo "</script>\n\n";
       }

      public function getLogContent($level = null) {
        if ($level == null) {
          $level = $this->defaultReporingLevel;
        }

        $logRows = $this->getLogContentArrayByLevel($level);
         for($i = 0; $i < count($logRows); $i++) {
             echo "[" . $logRows[$i]['timestamp'] . "] [" . $logRows[$i]['level'] . "] " .  $logRows[$i]['text'] . "\n";
         }
       }
}
