<?php

namespace App\Utils;

use App\Constants\BookConstants;
use App\DTO\Books\SearchBookQuery;

/**
 * Classe URLMaker
 * Permet la création d'URL à envoyer à Prismic selon le filtre choisi
 */
class PrismicURLMaker
{
    /**
     * Fonction qui permet de créer l'URL à envoyer à Prismic en choisissant selon le filtre
     * @param SearchBookQuery|null $filter
     * @param string $docType
     * @return string
     */
    public static function prismicQueryMaker(?SearchBookQuery $filter, string $docType): string
    {
        if ($filter && $filter->getType() === 'id') {
            $url = '[[at(document.id, "' . $filter->getValue() . '")]]';
            return $url;
        }

        /**
         * URL de base quand on recherche livres OU catégories
         */
        $url = '[[at(document.type,"' . $docType . '")]';

        if ($filter && $filter->getType() != '' && $filter->getValue()) {
            $url .= '[at(my.books.';
            $url .= match ($filter->getType()) {
                'category' => BookConstants::FILTER_BY_CATEGORY,
                'title' => BookConstants::FILTER_BY_TITLE,
                'author' => BookConstants::FILTER_BY_AUTHOR,
            };
            $url .= ',"' . $filter->getValue() . '")]';
        }

        $url .= ']';
        return $url;
    }

    /**
     * Fonction qui permet de créer l'URL à envoyer à Prismic en choisissant selon le type de contenu éditorial
     * @param string $editorialType
     * @return string
     */
    public static function prismicEditorialURLMaker(string $editorialType): string
    {
        return '[[at(document.type,"' . $editorialType . '")]]';
    }

}