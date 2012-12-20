<?php

namespace User\Validator;

use Zend\Validator\AbstractValidator;
use Doctrine\ORM\EntityManager;

/*
 * Validator for unique field.
 *
 * @author Benjamin Lazarecki <benjamin@widop.com>
 */
class UniqueField extends AbstractValidator
{
    const FIELD_FOUND = "FiledExist";

    /**
     * @var EntityManager the entity manager.
     */
    protected $entityManager;

    /**
     * @var string the field to check
     */
    protected $field;

    /**
     * @var string the repository
     */
    protected $repository;

    /**
     * @var array message template.
     */
    protected $messageTemplates = array();

    /**
     * {@inheritdoc}
     */
    public function __construct(array $options = null)
    {
        if (null !== $options) {
            $this
                ->setEntityManager($options['entityManager'])
                ->setRepository($options['repository'])
                ->setField($options['field']);
        }

        // Init messages
        $this->messageTemplates[self::FIELD_FOUND] = sprintf(
            'The %s is already used in the application', $this->getField());

        return parent::__construct($options);
    }

    /**
     * Gets the entity manager.
     *
     * @return EntityManager
     */
    public function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     * Sets the entity manager
     *
     * @param EntityManager $entityManager
     *
     * @return UniqueField
     */
    public function setEntityManager(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;

        return $this;
    }

    /**
     * Gets the field.
     *
     * @return string
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * Sets the field.
     *
     * @param string $field
     *
     * @return UniqueField
     */
    public function setField($field)
    {
        $this->field = $field;

        return $this;
    }

    /**
     * @return string The repository.
     */
    public function getRepository()
    {
        return $this->repository;
    }

    /**
     * Sets the repository.
     *
     * @param string $repository
     *
     * @return UniqueField
     */
    public function setRepository($repository)
    {
        $this->repository = $repository;

        return $this;
    }

    /**
     * {@inheritodc}
     */
    public function isValid($value)
    {
        $em = $this->getEntityManager();
        $field = $this->getField();
        $repository = $this->getRepository();

        $entity = $em->getRepository($repository)->findOneBy(array($field => $value));
        $entityExist = $entity !== null;

        if ($entityExist) {
            $this->error(self::FIELD_FOUND);
        }

        return !$entityExist;
    }
}
