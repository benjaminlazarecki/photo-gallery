<?php

namespace User\Controller;

use Doctrine\ORM\EntityManager,
    Zend\Mail\Message,
    Zend\Mail\Transport\Smtp as SmtpTransport,
    Zend\Mail\Transport\SmtpOptions,
    Zend\Mvc\Controller\AbstractActionController,
    Zend\View\Model\ViewModel,
    Zend\View\Model\JsonModel;

use User\Form\RegisterForm,
    User\Entity\User,
    User\Filter\RegisterFilter;

/**
 * Register controller.
 *
 * @author Benjamin Lazarecki <benjamin@widop.com>
 */
class RegisterController extends AbstractActionController
{
    /**
     * @var Doctrine\ORM\EntityManager
     */
    protected $em;

    /**
     * Set the entity manager.
     *
     * EntityManager is set on bootstrap.
     *
     * @param \Doctrine\ORM\EntityManager $em
     */
    public function setEntityManager(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * Get the entity manager
     *
     * @return Doctrine\ORM\EntityManager
     */
    public function getEntityManager()
    {
        return $this->em;
    }

    /**
     * Register a user.
     *
     * @return array
     */
    public function registerAction()
    {
		$jsonModel = new JsonModel();
        $viewmodel = new ViewModel();
        $viewmodel->setTerminal(true);

        $form = new RegisterForm();

        $request = $this->getRequest();
        if ($request->isPost()) {
            $user = new User();
            $form->setInputFilter(new RegisterFilter($this->getEntityManager()));
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $user->populate($form->getData());

                $password = $user->generatePassword();
                $user->setPlainPassword($password);

                $this->getEntityManager()->persist($user->getGallery());
                $this->getEntityManager()->persist($user);
                $this->getEntityManager()->flush();

                //$this->sendEMail($user);

                $message = 'Thank you for your registration! Please check your mail to get your password!';
                $this->flashMessenger()->setNamespace('success')->addMessage($message);

				$jsonModel->setVariable('finish', true);

				error_reporting(0);

                return $jsonModel;
            }
        }

        $viewmodel->setVariables(array(
            'form'          => $form,
            'noDisplayWell' => true,
        ));

        return $viewmodel;
    }

    /**
     * Send email with password.
     *
     * @param User $user
     */
    protected function sendEMail(User $user)
    {
        $username = $user->getUsername();
        $email = $user->getEmail();
        $plainPassword = $user->getPlainPassword();

        $message = new Message();

        $message
            ->addFrom("benjamin.lazarecki@etud.u-picardie.fr", "Photo-Gallery web site")
            ->addTo($email)
            ->setSubject("Thank for regiser, here your password!");
        $message
            ->setBody("Hello !\nUsername: $username\nPassword: $plainPassword");

        $config = $this->getServiceLocator()->get('Config');

        $transport = new SmtpTransport();
        $options   = new SmtpOptions($config['smtp']);
        $transport->setOptions($options);

        $transport->send($message);
    }
}

