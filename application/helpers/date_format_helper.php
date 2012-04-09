<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

function dateTimeToTimestamp($datetime)
{
    try
    {
        $date = new DateTime($datetime.' Europe/Berlin');
        $timestamp = $date->getTimestamp();
        return $timestamp;
    }catch(exception $e)
    {
        return FALSE;
    }
}