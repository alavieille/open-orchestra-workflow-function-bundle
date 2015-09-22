<?php

namespace OpenOrchestra\BackofficeBundle\Tests\Form\Type;

use OpenOrchestra\WorkflowFunctionAdminBundle\Form\Type\OrchestraWorkflowFunctionType;
use Phake;

/**
 * Description of OrchestraWorkflowFunctionTypeTest
 */
class OrchestraWorkflowFunctionTypeTest extends \PHPUnit_Framework_TestCase
{
    protected $workflowFunctionClass = 'fakeClass';
    protected $orchestraWorkflowFunction;
    protected $translationChoiceManager;

    /**
     * Set up the test
     */
    public function setUp()
    {
        $this->translationChoiceManager = Phake::mock('OpenOrchestra\Backoffice\Manager\TranslationChoiceManager');
        $this->orchestraWorkflowFunction = new OrchestraWorkflowFunctionType($this->workflowFunctionClass, $this->translationChoiceManager);
    }

    /**
     * test default options
     */
    public function testSetDefaultOptions()
    {
        $resolverMock = Phake::mock('Symfony\Component\OptionsResolver\OptionsResolver');

        $this->orchestraWorkflowFunction->configureOptions($resolverMock);
        $translationChoiceManager = $this->translationChoiceManager;

        Phake::verify($resolverMock)->setDefaults(
            array(
                'multiple' => true,
                'expanded' => true,
                'required' => false,
                'class' => $this->workflowFunctionClass,
                'choice_label' => function (WorkflowFunctionInterface $choice) use ($translationChoiceManager) {
                    return $translationChoiceManager->choose($choice->getNames());
                },
            )
        );
    }

    /**
     * Test parent
     */
    public function testGetParent()
    {
        $this->assertEquals('document', $this->orchestraWorkflowFunction->getParent());
    }

    /**
     * test Name
     */
    public function testGetName()
    {
        $this->assertEquals('orchestra_workflow_function', $this->orchestraWorkflowFunction->getName());
    }
}
