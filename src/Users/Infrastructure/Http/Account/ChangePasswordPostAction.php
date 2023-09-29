<?php

declare(strict_types=1);

namespace App\Users\Infrastructure\Http\Account;

use App\Shared\Application\Command\CommandBusInterface;
use App\Users\Application\Command\ChangePassword\ChangePasswordCommand;
use App\Users\Domain\Exception\DomainException;
use App\Users\Infrastructure\Forms\ChangePasswordType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
#[Route('/account/change-password', name: 'change_password', methods: ['POST'])]
class ChangePasswordPostAction extends AbstractController
{
    /**
     * @param CommandBusInterface $commandBus
     */
    public function __construct(
        private readonly CommandBusInterface $commandBus,
    ) {
    }

    /**
     * @param  Request  $request
     * @return Response
     */
    public function __invoke(Request $request): Response
    {
        $form = $this->createForm(ChangePasswordType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->process($form);
        } elseif ($form->isSubmitted()) {
            $this->addFlash('error', $form->getErrors(true)->current()->getMessage());
        }

        return $this->redirectToRoute('change_password_page');
    }

    /**
     * @param  FormInterface $form
     * @return void
     */
    public function process(FormInterface $form): void
    {
        try {
            $email = $this->getUser()->getUserIdentifier();
            $password = $form->get('password')->getData();
            $this->commandBus->handle(
                new ChangePasswordCommand($email, $password),
            );
            $this->addFlash('success', 'Password changed successfully');
        } catch (DomainException $e) {
            $this->addFlash('error', $e->getMessage());
        }
    }
}
