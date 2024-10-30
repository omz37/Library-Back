<?php

namespace App\Constants;

/**
 * Classe ErrorMessageConstants
 * qui contient les constantes avec les messages d'erreurs.
 */
class ErrorMessageConstants
{
    /**
     * @const string
     * Message d'erreur quand l'email saisi n'est pas unique
     */
    public const ERR_EMAIL_NOT_UNIQUE = 'Your Email is not unique !';

    /**
     * @const string
     * Message d'erreur quand le nom saisi est plus court que 2 chars
     */
    public const ERR_NAME_TOO_SHORT = 'Your name must be at least 2 characters long';

    /**
     * @const string
     * Message d'erreur quand le nom saisi est plus long que 50 chars
     */
    public const ERR_NAME_TOO_LONG = 'Your name cannot be longer than 50 characters';

    /**
     * @const string
     * Message d'erreur quand le mot de passe saisi est plus court que 2 chars
     */
    public const ERR_PASS_TOO_SHORT = 'Your password must be at least 2 characters long';

    /**
     * @const string
     * Message d'erreur quand le mot de passe saisi est plus long que 255 chars
     */
    public const ERR_PASS_TOO_LONG = 'Your password cannot be longer than 255 characters';

    /**
     * @const string
     * Message d'erreur quand une erreur imprévue arrive
     */
    public const ERR_UNEXPECTED = 'Error: an unexpected error happened !';

    /**
     * @const string
     * Message d'erreur quand une erreur de type mauvaise requête se produit
     */
    public const ERR_BAD_REQUEST = 'Error: Bad Request ! please check the info again !';

    /**
     * @const string
     * Message d'erreur quand une erreur de type livre non disponible
     */
    public const ERR_UNAVAILABLE_BOOK = 'Error: Book already rented !';

    /**
     * @const string
     * Message d'erreur quand une erreur de type non authorisé se produit
     */
    public const ERR_FORBIDDEN = 'Error: forbidden behavior, please check your credentials !';

    /**
     * @const string
     * Message d'erreur quand une erreur de type non trouvé se produit
     */
    public const ERR_NOT_FOUND = 'Error : user not found !';
}
