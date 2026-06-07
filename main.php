<?php
/**
 * MAIN.PHP — Legacy file (redirects to index.php)
 * ================================================
 * This file used to be the main CRUD page but has been replaced
 * by index.php (which is more secure and beginner-friendly).
 *
 * If you linked to main.php anywhere, this redirect will
 * automatically send you to the correct page.
 *
 * Compare main.php (old) vs index.php (new) to see what improved:
 *   ✅ Prepared statements (no SQL injection)
 *   ✅ Input validation (no empty/invalid data)
 *   ✅ Bootstrap styling (looks professional)
 *   ✅ Flash messages (success/error feedback)
 *   ✅ Proper error handling (not just die())
 */

header('Location: index.php');
exit;
