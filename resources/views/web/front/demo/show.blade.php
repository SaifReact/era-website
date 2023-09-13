@extends('layouts.web.app')
@section('title')

@endsection
@section('meta')
    @parent
    <meta name="description" content="" />
@endsection
@section('css')
    @parent
    <link href="{{ asset('css/pages.css') }}" rel="stylesheet">
@endsection
@section('content')
    @include('web.front.partials.header')

    <main id="main">
        @include('web.front.partials.breadcrumb')
        <section class="inner-page">
            <div class="container">
                <article class="entry entry-single" data-aos="fade-up">
                    <div class="row mb-4 ps-5">
                        <div class="col-lg-4 mb-4 d-flex">
                            <div class="service-icon-wrapper d-flex align-items-center  justify-content-center"><i class="fas fa fa-cube"></i></div>
                            <div class="service-content-wrapper"><h5 class="text-dark">Software Development</h5></div>
                        </div>
                        <div class="col-lg-4 mb-4 d-flex">
                            <div class="service-icon-wrapper d-flex align-items-center  justify-content-center"><i class="fas fa fa-database"></i></div>
                            <div class="service-content-wrapper"><h5 class="text-dark">Database Maintenance</h5></div>
                        </div>
                        <div class="col-lg-4 mb-4 d-flex">
                            <div class="service-icon-wrapper d-flex align-items-center  justify-content-center"><i class="fas fa fa-cubes"></i></div>
                            <div class="service-content-wrapper"><h5 class="text-dark">Application Management</h5></div>
                        </div>
                        <div class="col-lg-4 mb-4 d-flex">
                            <div class="service-icon-wrapper d-flex align-items-center  justify-content-center"><i class="fas fa fa-university"></i></div>
                            <div class="service-content-wrapper"><h5 class="text-dark">Infrastructure Management</h5></div>
                        </div>
                        <div class="col-lg-4 mb-4 d-flex">
                            <div class="service-icon-wrapper d-flex align-items-center  justify-content-center"><i class="fas fa fa-check-square"></i></div>
                            <div class="service-content-wrapper"><h5 class="text-dark">Quality Assurance & Testing</h5></div>
                        </div>
                        <div class="col-lg-4 mb-4 d-flex">
                            <div class="service-icon-wrapper d-flex align-items-center  justify-content-center"><i class="fas fa fa-cogs"></i></div>
                            <div class="service-content-wrapper"><h5 class="text-dark">Business Process Re - engineering</h5></div>
                        </div>
                        <div class="col-lg-4 mb-4 d-flex">
                            <div class="service-icon-wrapper d-flex align-items-center  justify-content-center"><i class="fas fa fa-cog"></i></div>
                            <div class="service-content-wrapper"><h5 class="text-dark">Software Maintenance & Services</h5></div>
                        </div>
                        <div class="col-lg-4 mb-4 d-flex">
                            <div class="service-icon-wrapper d-flex align-items-center  justify-content-center"><i class="fas fa fa-laptop"></i></div>
                            <div class="service-content-wrapper"><h5 class="text-dark">3rd Party Integration</h5></div>
                        </div>
                        <div class="col-lg-4 mb-4 d-flex">
                            <div class="service-icon-wrapper d-flex align-items-center  justify-content-center"><i class="fas fa fa-sitemap"></i></div>
                            <div class="service-content-wrapper"><h5 class="text-dark">Insourcing of IT operations</h5></div>
                        </div>
                    </div>

                    <div class="row py-4 bg-gray rounded-pill">
                        <div class="col">
                            <h1 class="d-flex justify-content-center">EXPERTISE</h1>
                        </div>
                    </div>

                    <div class="row mt-4 ps-5">
                        <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                            <h5 class="text-dark">Java</h5>
                            <ul class="list-unstyled">
                                <li class="d-table"><i class="bi bi-check-lg px-3 text-primary lh-lg"></i>
                                    <div class="d-table-cell">Struts 1/2</div>
                                </li>
                                <li class="d-table"><i class="bi bi-check-lg px-3 text-primary lh-lg"></i>
                                    <div class="d-table-cell">Spring 2</div>
                                </li>
                                <li class="d-table"><i class="bi bi-check-lg px-3 text-primary lh-lg"></i>
                                    <div class="d-table-cell">Hibernate</div>
                                </li>
                            </ul>
                        </div>
                        <div class="col-lg-3 col-md-4 col-sm-6 mb-3"><h5 class="text-dark">Mobile Apps</h5>
                            <ul class="list-unstyled">
                                <li class="d-table"><i class="bi bi-check-lg px-3 text-primary lh-lg"></i>
                                    <div class="d-table-cell">Java</div>
                                </li>
                                <li class="d-table"><i class="bi bi-check-lg px-3 text-primary lh-lg"></i>
                                    <div class="d-table-cell">Swift</div>
                                </li>
                                <li class="d-table"><i class="bi bi-check-lg px-3 text-primary lh-lg"></i>
                                    <div class="d-table-cell">Android/ IOS</div>
                                </li>
                                <li class="d-table"><i class="bi bi-check-lg px-3 text-primary lh-lg"></i>
                                    <div class="d-table-cell">Xamarin</div>
                                </li>
                                <li class="d-table"><i class="bi bi-check-lg px-3 text-primary lh-lg"></i>
                                    <div class="d-table-cell">React Native</div>
                                </li>
                            </ul>
                        </div>
                        <div class="col-lg-3 col-md-4 col-sm-6 mb-3"><h5 class="text-dark">Testing</h5>
                            <ul class="list-unstyled">
                                <li class="d-table"><i class="bi bi-check-lg px-3 text-primary lh-lg"></i>
                                    <div class="d-table-cell">Selenium WebDriver</div>
                                </li>
                                <li class="d-table"><i class="bi bi-check-lg px-3 text-primary lh-lg"></i>
                                    <div class="d-table-cell">KaLi Linux</div>
                                </li>
                            </ul>
                        </div>
                        <div class="col-lg-3 col-md-4 col-sm-6 mb-3"><h5 class="text-dark">Reporting</h5>
                            <ul class="list-unstyled">
                                <li class="d-table"><i class="bi bi-check-lg px-3 text-primary lh-lg"></i>
                                    <div class="d-table-cell">Crystal report</div>
                                </li>
                                <li class="d-table"><i class="bi bi-check-lg px-3 text-primary lh-lg"></i>
                                    <div class="d-table-cell">iReport</div>
                                </li>
                                <li class="d-table"><i class="bi bi-check-lg px-3 text-primary lh-lg"></i>
                                    <div class="d-table-cell">Jasper Reports</div>
                                </li>
                            </ul>
                        </div>
                        <div class="col-lg-3 col-md-4 col-sm-6 mb-3"><h5 class="text-dark">Oracle</h5>
                            <ul class="list-unstyled">
                                <li class="d-table"><i class="bi bi-check-lg px-3 text-primary lh-lg"></i>
                                    <div class="d-table-cell">Database 11g/12c</div>
                                </li>
                                <li class="d-table"><i class="bi bi-check-lg px-3 text-primary lh-lg"></i>
                                    <div class="d-table-cell">Developer 6i/10g/11g/12c</div>
                                </li>
                                <li class="d-table"><i class="bi bi-check-lg px-3 text-primary lh-lg"></i>
                                    <div class="d-table-cell">Apex</div>
                                </li>
                            </ul>
                        </div>
                        <div class="col-lg-3 col-md-4 col-sm-6 mb-3"><h5 class="text-dark">Microsoft</h5>
                            <ul class="list-unstyled">
                                <li class="d-table"><i class="bi bi-check-lg px-3 text-primary lh-lg"></i>
                                    <div class="d-table-cell">SQL server</div>
                                </li>
                                <li class="d-table"><i class="bi bi-check-lg px-3 text-primary lh-lg"></i>
                                    <div class="d-table-cell">.Net/.Net core</div>
                                </li>
                                <li class="d-table"><i class="bi bi-check-lg px-3 text-primary lh-lg"></i>
                                    <div class="d-table-cell">MVC</div>
                                </li>
                                <li class="d-table"><i class="bi bi-check-lg px-3 text-primary lh-lg"></i>
                                    <div class="d-table-cell">Entity Framework</div>
                                </li>
                                <li class="d-table"><i class="bi bi-check-lg px-3 text-primary lh-lg"></i>
                                    <div class="d-table-cell">Web API</div>
                                </li>
                            </ul>
                        </div>
                        <div class="col-lg-3 col-md-4 col-sm-6 mb-3"><h5 class="text-dark">CI & CD</h5>
                            <ul class="list-unstyled">
                                <li class="d-table"><i class="bi bi-check-lg px-3 text-primary lh-lg"></i>
                                    <div class="d-table-cell">Bamboo</div>
                                </li>
                                <li class="d-table"><i class="bi bi-check-lg px-3 text-primary lh-lg"></i>
                                    <div class="d-table-cell">Jenkins</div>
                                </li>
                            </ul>
                        </div>
                        <div class="col-lg-3 col-md-4 col-sm-6 mb-3"><h5 class="text-dark">Cloud</h5>
                            <ul class="list-unstyled">
                                <li class="d-table"><i class="bi bi-check-lg px-3 text-primary lh-lg"></i>
                                    <div class="d-table-cell">AWS</div>
                                </li>
                                <li class="d-table"><i class="bi bi-check-lg px-3 text-primary lh-lg"></i>
                                    <div class="d-table-cell">Azure</div>
                                </li>
                            </ul>
                        </div>
                        <div class="col-lg-3 col-md-4 col-sm-6 mb-3"><h5 class="text-dark">ALM</h5>
                            <ul class="list-unstyled">
                                <li class="d-table"><i class="bi bi-check-lg px-3 text-primary lh-lg"></i>
                                    <div class="d-table-cell">Jira + Confluence</div>
                                </li>
                                <li class="d-table"><i class="bi bi-check-lg px-3 text-primary lh-lg"></i>
                                    <div class="d-table-cell">Team Foundation Server</div>
                                </li>
                            </ul>
                        </div>
                        <div class="col-lg-3 col-md-4 col-sm-6 mb-3"><h5 class="text-dark">Source Control</h5>
                            <ul class="list-unstyled">
                                <li class="d-table"><i class="bi bi-check-lg px-3 text-primary lh-lg"></i>
                                    <div class="d-table-cell">Git</div>
                                </li>
                                <li class="d-table"><i class="bi bi-check-lg px-3 text-primary lh-lg"></i>
                                    <div class="d-table-cell">VSTS</div>
                                </li>
                                <li class="d-table"><i class="bi bi-check-lg px-3 text-primary lh-lg"></i>
                                    <div class="d-table-cell">Bit Bucket</div>
                                </li>
                            </ul>
                        </div>
                        <div class="col-lg-3 col-md-4 col-sm-6 mb-3"><h5 class="text-dark">Web</h5>
                            <ul class="list-unstyled">
                                <li class="d-table"><i class="bi bi-check-lg px-3 text-primary lh-lg"></i>
                                    <div class="d-table-cell">Javascript</div>
                                </li>
                                <li class="d-table"><i class="bi bi-check-lg px-3 text-primary lh-lg"></i>
                                    <div class="d-table-cell">HTML</div>
                                </li>
                                <li class="d-table"><i class="bi bi-check-lg px-3 text-primary lh-lg"></i>
                                    <div class="d-table-cell">XML</div>
                                </li>
                                <li class="d-table"><i class="bi bi-check-lg px-3 text-primary lh-lg"></i>
                                    <div class="d-table-cell">Angular JS</div>
                                </li>
                                <li class="d-table"><i class="bi bi-check-lg px-3 text-primary lh-lg"></i>
                                    <div class="d-table-cell">jQuery</div>
                                </li>
                            </ul>
                        </div>
                        <div class="col-lg-3 col-md-4 col-sm-6 mb-3"><h5 class="text-dark">Others</h5>
                            <ul class="list-unstyled">
                                <li class="d-table"><i class="bi bi-check-lg px-3 text-primary lh-lg"></i>
                                    <div class="d-table-cell">Python</div>
                                </li>
                                <li class="d-table"><i class="bi bi-check-lg px-3 text-primary lh-lg"></i>
                                    <div class="d-table-cell">DHTML</div>
                                </li>
                                <li class="d-table"><i class="bi bi-check-lg px-3 text-primary lh-lg"></i>
                                    <div class="d-table-cell">XSL</div>
                                </li>
                                <li class="d-table"><i class="bi bi-check-lg px-3 text-primary lh-lg"></i>
                                    <div class="d-table-cell">Node JS</div>
                                </li>
                                <li class="d-table"><i class="bi bi-check-lg px-3 text-primary lh-lg"></i>
                                    <div class="d-table-cell">MongoDB</div>
                                </li>
                                <li class="d-table"><i class="bi bi-check-lg px-3 text-primary lh-lg"></i>
                                    <div class="d-table-cell">AR</div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </article>
            </div>
        </section>
    </main><!-- End #main -->
@endsection
