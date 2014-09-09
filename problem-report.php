<?php

include('Mail.php');
include_once('include/settings.php');

/**
 * Process an HTTP POST request based on the following fields:
 * reporter: email address of reporter
 * sendcopy: send a copy of message to the reporter (yes|no)
 * summary: short summary of problem (used as title)
 * problem: detailed error report (used as body)
 * logfileupload: log files to attach
 */

// First check that we've been accessed via an HTTP POST request
if((strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') 
        && (!empty($_POST['reporter']))) {

    // Set-up basic headers
    $headers['From'] = test_input($_POST['reporter']);
    $headers['To'] = join(', ', $recipients);
    $headers['Subject'] = test_input($_POST['summary']);

    // If requested, add sender to the recipents
    if (!empty($_POST['sendcopy'])) {
        if (test_input($_POST['sendcopy']) == 'yes') {
            $headers['Cc'] = test_input($_POST['reporter']);
            $recipients[] = test_input($_POST['reporter']);
        }
    }

    // Get detailed problem
    $body = htmlspecialchars($_POST['problem']);

    // If we've got attachments, need to create a multipart message
    if (!empty($_FILES)) {
        // Define multipart boundary string
        $randomVal = md5(time());
        $mimeBoundary = "==Multipart_Boundary_x{$randomVal}x";

        // Define MIME header
        $headers['MIME-Version'] = "1.0";
        $headers['Content-Type'] = "multipart/mixed;\n boundary=\"{$mimeBoundary}\"";

        // Start Multipart Boundary above message
        $body = "This is a multi-part message in MIME format.\n\n" .
                "--{$mimeBoundary}\n" .
                "Content-Type: text/plain; charset=\"ISO-8859-1\"\n" .
                "Content-Transfer-Encoding: 7bit\n\n" .
                $body . "\n\n";

        // Loop through attachments
        foreach( $_FILES['logfileupload']['tmp_name'] as $index => $tmpName) {
            if(!empty($_FILES['logfileupload']['error'][$index])) {
                // Oh dear, there's a problem with this file.
                return false;
            }

            // Now check that the file isn't empty and that it is an uploaded file
            if(!empty($tmpName) && is_uploaded_file($tmpName)) {
                // We're good. Now get some info
                $fileType = $_FILES['logfileupload']['type'][$index];
                $fileName = $_FILES['logfileupload']['name'][$index];

                // Read file in binary mode (rb)
                $file = fopen($tmpName,'rb');
                $data = fread($file,filesize($tmpName));
                fclose($file);

                // Encode file data
                $data = chunk_split(base64_encode($data));

                // Add attachment to message
                $body .= "--{$mimeBoundary}\n" .
                        "Content-Type: {$fileType}; name=\"{$fileName}\"\n" .
                        "Content-Transfer-Encoding: base64\n" .
                        "Content-Disposition: attachment; filename=\"{$fileName}\"\n\n" .
                        $data . "\n\n";
            }
        }
        // Add final MIME boundary
        $body .= "--{$mimeBoundary}\n";
    }

    // Generate a mail object
    $mail_object =& Mail::factory('smtp',
            array(
                'host' => $settings['host'],
                'port' => $settings['port'],
                'auth' => $settings['auth'],
                'username' => $settings['username'],
                'password' => $settings['password'],
            ));

    // Now send it
    $status = $mail_object->send($recipients, $headers, $body);

    // Check for errors
    if (PEAR::isError($status)) {
        echo '<p>Message NOT sent:</p>\n'
            . '<p>' . $status->getMessage() . '</p>\n'
            . '<p>' . $status->getDebugInfo() . '</p>';
    } else {
        echo '<p>Message successfully sent!</p>';
    }
} else {
    // We've been accessed directly - report appropriately
    echo '<p>No form data received.</p>';
}

/**
 * Function to validate form input.
 * Strips unnecessary characters, removes backslashes and escapes any embedded HTML.
 * @param binary $data form input data
 * @return binary cleansed input data
 */
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}