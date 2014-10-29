<?php
/*
# Shane Kirk - OSA - Call Log ^2
#
# @Changepass[Class]  - handles the user changing their password
 */

class Changepass
{
    /**
     * @var object $db_connection The database connection
     */
    private $db_connection = null;
    /**
     * @var array $errors Collection of error messages
     */
    public $errors = array();
    /**
     * @var array $messages Collection of success / neutral messages
     */
    public $messages = array();

    /**
     * the function "__construct()" automatically starts whenever an object of this class is created,
     */
    public function __construct()
    {
        if (isset($_POST['changepass'])) {
            $this->changePassword();
        }
    }

    /**
     * handles the entire Change password process. checks all error possibilities
     * and creates a new password for the user in thedatabase if everything is fine
     */
    private function changePassword()
    {
        if ((!isset($_POST['user_password_new'])) || (!isset($_POST['user_password_repeat'])) || (!isset($_POST['user_password_old']))) {
            $this->errors[] = "Empty Password Field";
        } elseif ($_POST['user_password_new'] !== $_POST['user_password_repeat']) {
            $this->errors[] = "New Password and New password repeat are not the same";
        } elseif (strlen($_POST['user_password_new']) < 6) {
            $this->errors[] = "Password has a minimum length of 6 characters";
        } elseif ($_POST['user_password_old'] && $_POST['user_password_new'] && $_POST['user_password_repeat'] && ($_POST['user_password_new'] === $_POST['user_password_repeat'])) {
            // create a database connection
            $this->db_connection = new mysqli(Config::get('mysql/host'), Config::get('mysql/username'), Config::get('mysql/password'), Config::get('mysql/db'));

            // change character set to utf8 and check it
            if (!$this->db_connection->set_charset("utf8")) {
                $this->errors[] = $this->db_connection->error;
            }

            // if no connection errors (= working database connection)
            if (!$this->db_connection->connect_errno) {

                // escaping, additionally removing everything that could be (html/javascript-) code
                $user_name = $this->db_connection->real_escape_string(strip_tags($_SESSION['user_name'], ENT_QUOTES));

                //CHECK OLD PASSWORD FIRST
                $sql = "SELECT user_password_hash
                        FROM users
                        WHERE user_name = '" . $user_name . "' OR user_email = '" . $user_name . "';";

                $result = $this->db_connection->query($sql);

                // if this user exists
                if ($result->num_rows == 1) {

                    // get result row (as an object)
                    $result_row = $result->fetch_object();

                    // using PHP 5.5's password_verify() function to check if the provided password fits
                    // the hash of that user's password

                    if (password_verify(escape($_POST['user_password_old']), $result_row->user_password_hash)) {

                        $user_password = $_POST['user_password_new'];

                        // crypt the user's password with PHP 5.5's password_hash() function, results in a 60 character
                        // hash string. the PASSWORD_DEFAULT constant is defined by the PHP 5.5, or if you are using
                        // PHP 5.3/5.4, by the password hashing compatibility library
                        $user_password_hash = password_hash($user_password, PASSWORD_DEFAULT);

                        // write new user's password into database
                        $sql = "UPDATE users
                                SET user_password_hash = '" . $user_password_hash . "'
                                WHERE user_name = '" . $user_name . "' OR user_email = '" . $user_name . "';";

                        $update_query = $this->db_connection->query($sql);

                        // if user's password has been changed successfully
                        if ($update_query) {
                            $this->messages[] = "Your password has been changed, You must Login again.";

                        } else {
                            $this->errors[] = "Sorry, your password change failed. Please tell an Administrator.";
                        }
                    } else {
                        $this->errors[] = "Old password was invalid.";
                    }
                } else {
                    $this->errors[] = "User was not found.";
                }
            } else {
                $this->errors[] = "Sorry, no database connection.";
            }
        } else {
            $this->errors[] = "An unknown error occurred.";
        }
    }
}
