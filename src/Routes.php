<?php

namespace Enotas;

use Enotas\Anonymous;

class Routes
{

    /**
     * @return \Enotas\Anonymous
     */
    public static function empresa()
    {
        $anonymous = new Anonymous();

        $anonymous->base = static function () {
            return 'empresas';
        };

        $anonymous->details = static function ($id) {
            return "empresas/$id";
        };

        $anonymous->enable = static function ($id) {
            return "empresas/$id/habilitar";
        };

        $anonymous->disable = static function ($id) {
            return "empresas/$id/desabilitar";
        };

        return $anonymous;
    }

    /**
     * @return \Enotas\Anonymous
     */
    public static function nfse()
    {
        $anonymous = new Anonymous();

        $anonymous->base = static function ($empresaId) {
            return "empresas/$empresaId/nfes";
        };

        $anonymous->details = static function ($empresaId, $nfse_id) {
            return "empresas/$empresaId/nfes/$nfse_id";
        };

        $anonymous->details_external = static function ($empresaId, $idExterno) {
            return "empresas/$empresaId/nfes/porIdExterno/$idExterno";
        };

        return $anonymous;
    }
}
