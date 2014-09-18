<?php

if (!function_exists('user')) {
    /**
     * Get User Model
     * @return \User\User
     */
    function user()
    {
        $userModel = \Config::get('auth.model');
        return new $userModel;
    }
}
