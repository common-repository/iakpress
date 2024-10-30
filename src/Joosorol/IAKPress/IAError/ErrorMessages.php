<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Joosorol\IAKPress\IAError;


/**
 * Description of ErrorMessages
 *
 * @author bly
 */
class ErrorMessages
{
    const WRONG_USER_PASSWORD = 'wrong_user_password';
    const NO_ACCOUNT_FOUND = 'no_account_found';


    const LABELS = [
        self::WRONG_USER_PASSWORD => "Wrong username or password. Try signing again.",
        self::NO_ACCOUNT_FOUND => "No account found with this email address."
    ];
    

    public static function wrongUserOrPassword(array &$errors, $fieldName = self::WRONG_USER_PASSWORD)  {
        $errors[$fieldName] = self::LABELS[self::WRONG_USER_PASSWORD];
    }

    public static function noAccountFound(array &$errors, $fieldName = self::NO_ACCOUNT_FOUND)  {
        $errors[$fieldName] = self::LABELS[self::NO_ACCOUNT_FOUND];
    }
}