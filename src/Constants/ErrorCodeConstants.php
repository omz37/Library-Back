<?php

namespace App\Constants;

/**
 * Classe ErrorCodeConstants
 * qui contient les constantes avec les messages d'erreurs.
 */
class ErrorCodeConstants
{
    /**
     * @const string
     * Code d'erreur quand l'email saisi n'est pas unique
     */
    public const ERR_EMAIL_NOT_UNIQUE = 'email_not_unique';

    /**
     * @const string
     * Code d'erreur quand une erreur imprévue se produit
     */
    public const ERR_UNEXPECTED = 'unknown_error';

    /**
     * @const string
     * Code d'erreur quand une erreur de type mauvaise requête se produit
     */
    public const ERR_BAD_REQUEST = 'bad_request';

    /**
     * @const string
     * Code d'erreur quand une erreur de type non authorisé se produit
     */
    public const ERR_FORBIDDEN = 'forbidden';

    /**
     * @const string
     * Code d'erreur quand une erreur de type non trouvé se produit
     */
    public const ERR_NOT_FOUND = 'not_found';
}
