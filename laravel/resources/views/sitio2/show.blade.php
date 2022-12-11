@extends('sitio2.app')
@section('main-content')
    <section class="colorlib-blog" data-section="blog">
        <div class="colorlib-narrow-content">
            <div class="row">
                <div class="col-md-6 col-md-offset-3 col-md-pull-3 animate-box" data-animate-effect="fadeInLeft">
                    <span class="heading-meta">Mis notas</span>
                    <h2 class="colorlib-heading">Mis notas de programación y mas</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 animate-box" data-animate-effect="fadeInLeft">
                    <div class="blog-entry">
                        <div class="desc">
                            <span><small>Enero 1, 2022 </small> | <small> Web Design </small> | <small> <i class="far fa-comments"></i> 4</small></span>
                            <h3><a href="/v2/notas/{id}">Renovating National Gallery</a></h3>
                            <p>Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection