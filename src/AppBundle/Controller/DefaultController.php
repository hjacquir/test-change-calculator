<?php

declare(strict_types=1);

namespace AppBundle\Controller;

use AppBundle\Calculator\Mk1Calculator;
use AppBundle\Calculator\Mk2Calculator;
use AppBundle\Model\Change;
use AppBundle\Registry\CalculatorRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @var Change
     */
    private $change;

    /**
     * @var Response
     */
    private $response;

    /**
     * @var CalculatorRegistry
     */
    private $calculatorRegistry;

    /**
     * @var Mk1Calculator
     */
    private $mk1Calculator;

    /**
     * @var Mk2Calculator
     */
    private $mk2Calculator;

    /**
     * DefaultController constructor.
     * @param Response $response
     * @param CalculatorRegistry $calculatorRegistry
     * @param Change $change
     * @param Mk1Calculator $mk1Calculator
     * @param Mk2Calculator $mk2Calculator
     */
    public function __construct(
        Response $response,
        CalculatorRegistry $calculatorRegistry,
        Change $change,
        Mk1Calculator $mk1Calculator,
        Mk2Calculator $mk2Calculator
    )
    {
        $this->response = $response;
        $this->calculatorRegistry = $calculatorRegistry;
        $this->change = $change;
        $this->mk1Calculator = $mk1Calculator;
        $this->mk2Calculator = $mk2Calculator;
    }

    /**
     * @Route("/automaton/{modelName}/change/{amount}")
     */
    public function change($modelName, int $amount)
    {
        // @todo avoid to use addCalculator() inject an array of
        // calculator directly on registry instantiation.
        // Search in symfony docs if it is possible (MAY BE)
        $this->calculatorRegistry->addCalculator($this->mk1Calculator);
        $this->calculatorRegistry->addCalculator($this->mk2Calculator);

        $calculator = $this->calculatorRegistry
            ->getCalculatorFor($modelName);

        $code = Response::HTTP_NOT_FOUND;
        $content = '';

        if (null !== $calculator) {
            $code = Response::HTTP_NO_CONTENT;

            $currentChange =  $calculator->getChange($amount);

            if (null !== $currentChange) {
                $content = json_encode($currentChange);
                $code = Response::HTTP_OK;
            }
        }

        $this->response->setContent($content);
        $this->response->setStatusCode($code);

        return $this->response;
    }
}