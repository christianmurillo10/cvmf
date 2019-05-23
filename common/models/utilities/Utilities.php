<?php

namespace common\models\utilities;

use Yii;

class Utilities extends \yii\base\Model
{
    const YES = 1;
    const NO = 0;
    const CIVIL_STATUS_SINGLE = 1;
    const CIVIL_STATUS_MARRIED = 2;
    const CIVIL_STATUS_DIVORCED = 3;
    const CIVIL_STATUS_WIDOWED = 4;
    const GENDER_MALE = 1;
    const GENDER_FEMALE = 2;
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    const USER_STATUS_ACTIVE = 10;
    const USER_STATUS_INACTIVE = 0;
    const PAYMENT_TYPE_CASH = 1;
    const PAYMENT_TYPE_CHEQUE = 2;
    const PAYMENT_TYPE_PDC = 3;

    public static function get_ActiveSelect($id = null)
    {
        $active = [
            self::YES => 'Yes',
            self::NO => 'No',
        ];
        if (is_null($id))
            return $active;
        else
            return $active[$id];
    }

    public static function get_ActiveStatus($id = null)
    {
        $active = [
            self::STATUS_ACTIVE => 'Active',
            self::STATUS_INACTIVE => 'Inactive',
        ];
        if (is_null($id))
            return $active;
        else
            return $active[$id];
    }
    
    public static function get_ActiveColoredStatus($id = null) {
        $active = [
            self::STATUS_ACTIVE => '<span class="label label-success">Active</span>',
            self::STATUS_INACTIVE => '<span class="label label-danger">Inactive</span>',
        ];
        if (is_null($id))
            return $active;
        else
            return $active[$id];
    }

    public static function get_ActiveGenderType($id = null)
    {
        $active = [
            self::GENDER_MALE => 'Male',
            self::GENDER_FEMALE => 'Female',
        ];
        if (is_null($id))
            return $active;
        else
            return $active[$id];
    }

    public static function get_ActiveCivilStatusType($id = null)
    {
        $active = [
            self::CIVIL_STATUS_SINGLE => 'Single',
            self::CIVIL_STATUS_MARRIED => 'Married',
            self::CIVIL_STATUS_DIVORCED => 'Divorced',
            self::CIVIL_STATUS_WIDOWED => 'Widowed',
        ];
        if (is_null($id))
            return $active;
        else
            return $active[$id];
    }

    public static function get_ActivePaymentType($id = null)
    {
        $active = [
            self::PAYMENT_TYPE_CASH => 'Cash',
            self::PAYMENT_TYPE_CHEQUE => 'Cheque',
            self::PAYMENT_TYPE_PDC => 'Post Dated Cheque (PDC)',
        ];
        if (is_null($id))
            return $active;
        else
            return $active[$id];
    }

    public static function call_Session()
    {
        return Yii::$app->session;
    }

    public static function call_Request()
    {
        return Yii::$app->request;
    }

    public static function get_UserID()
    {
        return Yii::$app->user->id;
    }

    public static function get_Username()
    {
        return Yii::$app->user->username;
    }

    public static function get_UserEmail()
    {
        return Yii::$app->user->email;
    }

    public static function get_Date()
    {
        return date('Y-m-d');
    }

    public static function get_DateTime()
    {
        return date('Y-m-d H:i:s');
    }

    public static function setDateStandard($d)
    {
        return date('M d, Y', strtotime($d));
    }

    public static function setDateTimeStandard($d)
    {
        return date('M d, Y H:i:s', strtotime($d));
    }

    public static function setDateDash($d)
    {
        return date('M-d-Y', strtotime($d));
    }

    public static function setCapitalFirst($string)
    {
        return ucwords(strtolower($string));
    }

    public static function setCapitalAll($string)
    {
        return strtoupper($string);
    }

    public static function setLowerlAll($string)
    {
        return strtolower($string);
    }

    public static function setNumberFormat($n, $decimal)
    {
        return number_format($n, $decimal);
    }

    public static function setNumberFormatWithPeso($n, $decimal)
    {
        return '₱' . number_format($n, $decimal);
    }

    public static function setAdvanceNumberFormat($n)
    {
        return (float) str_replace(',', '', $n);
    }

    public static function get_ModelErrors($modelErrors)
    {
        $errorMsg = NULL;
        foreach ($modelErrors as $modelErrors) {
            foreach ($modelErrors as $messages) {
                $errorMsg .= $messages . '<br />';
            }
        }
        return $errorMsg;
    }

    public static function debug($test, $caption)
    {
        print $caption;
        print '<pre>';
        print_r($test);
        print '</pre>';
    }
}