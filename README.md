# Logger - a PHP logging class
_This logging class which makes logging in PHP web apps easy_


## LOGGING LEVELS:

### DEBUG
Information that you never need to see if the system is working properly. These would only be used in development, Examples:
*"Received a message on topic X from caller Y"
*"Sent 20 bytes on socket 9".

### INFO
Small amounts of information that may be useful to a user. Examples:
*"New user account created: u: $username, id: $user_id"
*"New job created: $jobname, id: $job_id"

### WARN
Information that the user may find alarming, and may affect the output of the application, but is part of the expected working of the system. Examples:
*"Could not load configuration file from <path>. Using defaults."

### ERROR
Something serious (but recoverable) has gone wrong. Examples:
*"$className could not be autoloaded."
*"Outgoing email failed. Recipient $email_to"

### FATAL
Something unrecoverable has happened. Examples:
*"Database connection failed with error #545643."
