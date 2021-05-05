<?php

namespace App\Requests;
use App\Request;

class Report extends Request
{
    public static function generalSales()
    {
        $sql = 'SELECT * FROM `kupon`';
        return self::request($sql);
    }

    public static function listClientsOnDate($date)
    {
        $sql='SELECT klient.nomer_i_seriya_pasporta, klient.familiya, klient.imya, klient.otchestvo, kupon.nunkt_posadki,
        kupon.nunkt_vysadki, bilet.tip, bilet.data_prodazhi, bilet.shifr_aviakompanii, aviakompaniya.nazvanie, aviakompaniya.naselennyj_punkt, 
        aviakompaniya.ulica, aviakompaniya.nomer_doma, aviakompaniya.ofis FROM `klient`, `kupon`, `bilet`, `aviakompaniya` 
        WHERE bilet.id = kupon.nomer_bileta AND klient.nomer_i_seriya_pasporta = kupon.nomer_i_seriya_pasporta_klienta 
        and bilet.shifr_aviakompanii = aviakompaniya.id and bilet.data_prodazhi =  '."'".$date."'";
        return self::request($sql);
    }

    public static function salesMonthSelectCompany()
    {
        return 0;
    }


}