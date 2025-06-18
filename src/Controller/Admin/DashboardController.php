<?php

namespace App\Controller\Admin;

use App\Entity\Circuito;
use App\Entity\Distrito;
use App\Entity\GradoEscolar;
use App\Entity\Institucion;
use App\Entity\Jornada;
use App\Entity\Modalidad;
use App\Entity\Nacionalidad;
use App\Entity\Nivel;
use App\Entity\Paralelo;
use App\Entity\Parentesco;
use App\Entity\PeriodoLectivo;
use App\Entity\Requisito;
use App\Entity\UniformeTalla;
use App\Entity\User;
use App\Entity\Zona;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;

#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class DashboardController extends AbstractDashboardController
{
    public function index(): Response
    {
        //return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // 1.1) If you have enabled the "pretty URLs" feature:
        return $this->redirectToRoute('admin_zona_index');
        //
        // 1.2) Same example but using the "ugly URLs" that were used in previous EasyAdmin versions:
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirectToRoute('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Matricula Symfony');
    }

    public function configureMenuItems(): iterable
    {
        //yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');

        yield MenuItem::section('Datos Institucional');
        yield MenuItem::linkToCrud('Zona', 'fas fa-list', Zona::class);
        yield MenuItem::linkToCrud('Distrito', 'fas fa-list', Distrito::class);
        yield MenuItem::linkToCrud('Circuito', 'fas fa-list', Circuito::class);
        yield MenuItem::linkToCrud('Institucion', 'fas fa-list', Institucion::class);

        yield MenuItem::section('Parametros de Matricula');
        yield MenuItem::linkToCrud('Nivel', 'fas fa-list', Nivel::class);
        yield MenuItem::linkToCrud('Periodo Lectivo', 'fas fa-list', PeriodoLectivo::class);
        yield MenuItem::linkToCrud('Modalidad', 'fas fa-list', Modalidad::class);
        yield MenuItem::linkToCrud('Jornanda', 'fas fa-list', Jornada::class);
        yield MenuItem::linkToCrud('Grado Escolar', 'fas fa-list', GradoEscolar::class);
        yield MenuItem::linkToCrud('Paralelo', 'fas fa-list', Paralelo::class);

        yield MenuItem::section('Parametros de Estudiante');
        yield MenuItem::linkToCrud('Nacionalidad', 'fas fa-list', Nacionalidad::class);
        yield MenuItem::linkToCrud('Parentesco', 'fas fa-list', Parentesco::class);
        yield MenuItem::linkToCrud('Uniforme Talla', 'fas fa-list', UniformeTalla::class);
        yield MenuItem::linkToCrud('Requisito', 'fas fa-list', Requisito::class);

        yield MenuItem::section('Sección de Usuarios');
        yield MenuItem::linkToCrud('Usuario', 'fas fa-list', User::class);
    }
}
