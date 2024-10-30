<?php

namespace App\Controller;

use App\Constants\BookConstants;
use App\Constants\ErrorCodeConstants;
use App\Constants\ErrorMessageConstants;
use App\DTO\Edito\CGUDTO;
use App\DTO\Edito\IntroDTO;
use App\DTO\Edito\RulesDTO;
use App\DTO\Edito\ScheduleDTO;
use App\DTO\Errors\RestException;
use App\Services\EditorialContentService;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Throwable;

#[Route('/api/edito')]
/**
 * @OA\Tag(name="Editorial Content")
 *
 * Classe EditorialContentController qui permet de créer
 * la route associée aux contenus éditoriaux.
 */
class EditorialContentController extends AbstractController
{
    /**
     * @var EditorialContentService
     */
    private EditorialContentService $editoService;

    /**
     * @param EditorialContentService $editorialContentService
     */
    public function __construct(EditorialContentService $editorialContentService)
    {
        $this->editoService = $editorialContentService;
    }


    #[Rest\Get('/cgu', name: 'cgu_list')]
    /**
     * Route qui permet d'obtenir toutes les CGU.
     *
     * @OA\Response(
     *    response=200,
     *    @OA\JsonContent(ref=@Model(type=CGUDTO::class)),
     *    description="Toutes les CGUS de la bibliothèque"
     *  )
     *
     * @OA\Response(
     *    response=400,
     *    description="Mauvaise requête: URL ou ref non valide"
     *  )
     *
     * @return CGUDTO|RestException
     * @throws RestException
     */
    public function getCGUAction(): CGUDTO|RestException
    {
        try {
            return $this->editoService->EditorialContentDTOMaker(BookConstants::TYPE_CGU);
        } catch (RestException $restException) {
            throw $restException;
        } catch (Throwable $throwable) {
            throw new RestException(Response::HTTP_INTERNAL_SERVER_ERROR, ErrorCodeConstants::ERR_UNEXPECTED, ErrorMessageConstants::ERR_UNEXPECTED);
        }
    }

    #[Rest\Get('/intro', name: 'intro_text')]
    /**
     * Route qui permet d'obtenir le texte et l'image d'introduction.
     *
     * @OA\Response(
     *    response=200,
     *    @OA\JsonContent(ref=@Model(type=IntroDTO::class)),
     *    description="Texte d'introduction de la bibliothèque"
     *  )
     *
     * @OA\Response(
     *    response=400,
     *    description="Mauvaise requête: URL ou ref non valide"
     *  )
     *
     * @return IntroDTO|RestException
     * @throws RestException
     */
    public function getIntroAction(): IntroDTO|RestException
    {
        try {
            return $this->editoService->EditorialContentDTOMaker(BookConstants::TYPE_INTRODUCTION);
        } catch (RestException $restException) {
            throw $restException;
        } catch (Throwable $throwable) {
            throw new RestException(Response::HTTP_INTERNAL_SERVER_ERROR, ErrorCodeConstants::ERR_UNEXPECTED, ErrorMessageConstants::ERR_UNEXPECTED);
        }
    }

    #[Rest\Get('/rules', name: 'rule_list')]
    /**
     * Route qui permet d'obtenir le règlement intérieur.
     *
     * @OA\Response(
     *    response=200,
     *    @OA\JsonContent(ref=@Model(type=RulesDTO::class)),
     *    description="Toutes les règles de la bibliothèque"
     *  )
     *
     * @OA\Response(
     *    response=400,
     *    description="Mauvaise requête: URL ou ref non valide"
     *  )
     *
     * @return RulesDTO|RestException
     * @throws RestException
     */
    public function getRulesAction(): RulesDTO|RestException
    {
        try {
            return $this->editoService->EditorialContentDTOMaker(BookConstants::TYPE_RULES);
        } catch (RestException $restException) {
            throw $restException;
        } catch (Throwable $throwable) {
            throw new RestException(Response::HTTP_INTERNAL_SERVER_ERROR, ErrorCodeConstants::ERR_UNEXPECTED, ErrorMessageConstants::ERR_UNEXPECTED);
        }
    }

    #[Rest\Get('/schedule', name: 'schedule')]
    /**
     * Route qui permet d'obtenir les horaires.
     *
     * @OA\Response(
     *    response=200,
     *    @OA\JsonContent(ref=@Model(type=ScheduleDTO::class)),
     *    description="Toutes les horaires de la bibliothèque"
     *  )
     *
     * @OA\Response(
     *    response=400,
     *    description="Mauvaise requête: URL ou ref non valide"
     *  )
     *
     * @return ScheduleDTO|RestException
     * @throws RestException
     */
    public function getScheduleAction(): ScheduleDTO|RestException
    {
        try {
            return $this->editoService->EditorialContentDTOMaker(BookConstants::TYPE_SCHEDULE);
        } catch (RestException $restException) {
            throw $restException;
        } catch (Throwable $throwable) {
            throw new RestException(Response::HTTP_INTERNAL_SERVER_ERROR, ErrorCodeConstants::ERR_UNEXPECTED, ErrorMessageConstants::ERR_UNEXPECTED);
        }
    }
}