<?php

declare(strict_types=1);

namespace App\Users\Infrastructure\Http\Users;

use App\Shared\Application\Command\CommandBusInterface;
use App\Users\Application\Command\ImportUsers\ImportUsersFromCsvCommand;
use App\Users\Infrastructure\Forms\ImportUsersType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use const DIRECTORY_SEPARATOR;

#[AsController]
#[Route('/users/import', name: 'import_users', methods: ['POST'])]
class ImportUsersPostAction extends AbstractController
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
        $form = $this->createForm(ImportUsersType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->process($form);
        } elseif ($form->isSubmitted()) {
            $this->addFlash('error', $form->getErrors(true)->current()->getMessage());
        }

        return $this->redirectToRoute('import_users_page');
    }

    /**
     * @param  FormInterface $form
     * @return void
     */
    public function process(FormInterface $form): void
    {
        try {
            $uploadedFile = $form->get('file')->getData();
            $newFilename = uniqid('users', true) . '.csv';
            $uploadedFile->move($this->getParameter('users_import_directory'), $newFilename);
            $path = $this->getParameter('users_import_directory') . DIRECTORY_SEPARATOR . $newFilename;

            $this->commandBus->handle(new ImportUsersFromCsvCommand($path));
            $this->addFlash('success', 'File uploaded');
        } catch (FileException $e) {
            $this->addFlash('error', $e->getMessage());
        }
    }
}
