<?php
class Validation {
    // Sanitize input to prevent XSS attacks
    public function sanitizeInput($input) {
        return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
    }

    // Validate email format
    public function validateEmail($email) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return "Invalid email format";
        }
        return true;
    }

    public function validateCustomString($input) {
        // Regular expression to match allowed characters: numbers, alphabets, spaces, underscores, hyphens, and commas
        if (preg_match('/^[a-zA-Z0-9 _,-]*$/', $input)) {
            return true; // Valid input
        } else {
            return "Invalid input: Only numbers, alphabets, spaces, underscores, hyphens, and commas are allowed.";
        }
    }

    // Validate password strength
    public function validatePassword($password) {
        if (strlen($password) < 8) {
            return "Password must be at least 8 characters long";
        }
        if (!preg_match('/[A-Za-z]/', $password) || !preg_match('/\d/', $password)) {
            return "Password must include both letters and numbers";
        }
        return true;
    }

    // Validate username (for example, alphanumeric and underscores only)
    public function validateUsername($username) {
        if (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
            return "Username can only contain letters, numbers, and underscores";
        }
        return true;
    }

    // Check if passwords match
    public function passwordsMatch($password1, $password2) {
        if ($password1 !== $password2) {
            return "Passwords do not match";
        }
        return true;
    }

    // Validate date format (YYYY-MM-DD)
    public function validateDate($date, $format = 'Y-m-d') {
        $d = DateTime::createFromFormat($format, $date);
        if ($d && $d->format($format) === $date) {
            return true;
        }
        return "Invalid date format. Expected format: YYYY-MM-DD";
    }

    // Validate phone number (simple check for digits and optional '+' sign)
    public function validatePhoneNumber($phoneNumber) {
        if (!preg_match('/^\+?\d{10,15}$/', $phoneNumber)) {
            return "Invalid phone number";
        }
        return true;
    }

    // Check if date is today or any day before today
    public function validateDateTodayOrBefore($date, $format = 'Y-m-d') {
        $d = DateTime::createFromFormat($format, $date);
        $today = new DateTime();
        if ($d && $d->format($format) === $date) {
            if ($d <= $today) {
                return true;
            } else {
                return "Date must be today or any day before today";
            }
        }
        return "Invalid date format. Expected format: YYYY-MM-DD";
    }

    // Check if date is today or any day after today
    public function validateDateTodayOrAfter($date, $format = 'Y-m-d') {
        $d = DateTime::createFromFormat($format, $date);
        $today = new DateTime();
        if ($d && $d->format($format) === $date) {
            if ($d >= $today) {
                return true;
            } else {
                return "Date must be today or any day after today";
            }
        }
        return "Invalid date format. Expected format: YYYY-MM-DD";
    }
}
?>
